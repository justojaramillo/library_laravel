<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{

    /**
     * Display a listing of loans for the Admin (All Loans).
     * Ruta: GET /api/loans/all (Protegida por ability:admin)
     */
    public function indexAdmin()
    {
        // Administrador ve todos los préstamos, cargando Book y User
        $loans = Loan::with(['book.author', 'user'])
                      ->latest('loan_date')
                      ->paginate(15);
                      
        return LoanResource::collection($loans);
    }
    /**
     * Display a listing of loans for the Client (My Loans).
     * Ruta: GET /api/loans/me (Protegida por auth:sanctum)
     */
    public function indexClient(Request $request)
    {
        // Cliente solo ve sus propios préstamos
        $userId = $request->user()->user_id;
        
        $loans = Loan::where('user_id', $userId)
                      ->with('book.author')
                      ->latest('loan_date')
                      ->paginate(10);
                      
        return LoanResource::collection($loans);
    }

    /**
     * Display a listing of loans for a specific User (Admin functionality).
     * Ruta: GET /api/loans/user/{userId} (Protegida por ability:admin)
     */
    public function indexUser(int $userId)
    {
        // Administrador busca préstamos por un user_id específico.
        // Se cargan las relaciones Book y User.
        $loans = Loan::where('user_id', $userId)
                      ->with(['book.author', 'user'])
                      ->latest('loan_date')
                      ->paginate(5);
                      
        // Si no hay préstamos, la colección estará vacía, lo cual es correcto.
        return LoanResource::collection($loans);
    }

    /**
     * Store a newly created loan in storage. (Client/Admin)
     * Ruta: POST /api/loans (Protegida por auth:sanctum)
     */
    public function store(Request $request)
    {
        // Validar que el book_id exista y sea un entero
        $request->validate([
            'book_id' => ['required', 'integer', 'exists:books,book_id'], 
        ]);
        
        $book = Book::find($request->book_id);
        
        // --- Lógica de Negocio 1: Verificar Stock ---
        if ($book->stock <= 0) {
            throw ValidationException::withMessages(['book_id' => ['The requested book is currently out of stock.']]);
        }
        
        // --- Lógica de Negocio 2: Verificar Préstamo Activo ---
        // Verificar si el usuario ya tiene este libro prestado sin devolver
        $existingLoan = Loan::where('user_id', $request->user()->user_id)
                            ->where('book_id', $request->book_id)
                            ->where('returned', false)
                            ->first();

        if ($existingLoan) {
            throw ValidationException::withMessages(['book_id' => ['You already have this book borrowed and have not returned it.']]);
        }

        // Crear el préstamo
        $loan = Loan::create([
            'book_id' => $book->book_id,
            'user_id' => $request->user()->user_id,
            'loan_date' => Carbon::now()->format('Y-m-d'),
            'returned' => false,
        ]);
        
        // --- Lógica de Negocio 3: Reducir Stock ---
        $book->decrement('stock');

        // Cargar las relaciones necesarias para el Resource
        $loan->load('book.author');

        return response()->json([
            'message' => 'Book successfully borrowed.',
            'loan' => new LoanResource($loan)
        ], Response::HTTP_CREATED);
    }

    /**
     * Mark a loan as returned by the client. (Client/Admin)
     * Ruta: POST /api/loans/return/{loan} (Protegida por auth:sanctum)
     */
    public function returnLoan(Loan $loan, Request $request)
    {
        // Verificar que el préstamo pertenezca al usuario autenticado (medida de seguridad)
        if ($loan->user_id !== $request->user()->user_id) {
             return response()->json(['message' => 'Unauthorized action or loan not found.'], Response::HTTP_FORBIDDEN);
        }

        return $this->processReturn($loan);
    }

    /**
     * Mark a loan as returned by an Admin (Forced return).
     * Ruta: POST /api/loans/force-return/{loan} (Protegida por ability:admin)
     */
    public function forceReturn(Loan $loan)
    {
        // El administrador no necesita verificar si el préstamo le pertenece.
        return $this->processReturn($loan);
    }

    /**
     * Shared method to handle the return logic (Marcar como devuelto y aumentar stock).
     */
    protected function processReturn(Loan $loan)
    {
        // Verificar que el préstamo no haya sido devuelto ya
        if ($loan->returned) {
            return response()->json(['message' => 'This loan has already been returned.'], Response::HTTP_BAD_REQUEST);
        }

        // --- Lógica de Negocio: Marcar Devolución y Aumentar Stock ---
        $loan->update([
            'returned' => true,
            'return_date' => Carbon::now()->format('Y-m-d'),
        ]);

        // Aumentar el stock del libro
        $loan->book()->increment('stock');
        
        $loan->load('book.author', 'user');

        return response()->json([
            'message' => 'Book successfully returned and stock updated.',
            'loan' => new LoanResource($loan)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        // Se añade una restricción para asegurar que solo se eliminen registros históricos (devueltos)
        if (!$loan->returned) {
             return response()->json(['message' => 'Cannot delete an active (not returned) loan. Please force return it first.'], Response::HTTP_BAD_REQUEST);
        }
        
        $loan->delete();
        
        // No Content (204) es estándar para eliminaciones exitosas
        return response()->json(['message' => 'Loan record deleted successfully.'], Response::HTTP_NO_CONTENT);
    }
}
