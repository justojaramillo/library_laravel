<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los libros y precargar la relación 'author' para evitar el problema N+1.
        $books = Book::with('author')->paginate(5);

        // Devolver una colección de BookResource
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // La validación se maneja en StoreBookRequest
        
        // 1. Crear el libro
        $book = Book::create($request->validate([
            'title'=>'required|string|max:150', 
            'isbn'=>'required|string|max:20|unique:books,isbn', 
            'author_id'=>'required|integer', 
            'category'=>'nullable|string|max:100',
            'stock'=>'required|integer|min:0',
            'price'=>'required|numeric|min:0.00|max:9999.99'
        ]));

        // 2. Devolver la respuesta con el recurso recién creado
        return response()->json([
            'message' => 'Book created successfully.',
            'book' => new BookResource($book->load('author')) // Aplicamos el Resource
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        // Devolver una instancia de BookResource
        return new BookResource($book->load('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // La validación se maneja en StoreBookRequest (usaremos un truco para UPDATE)
        //validar
        $request->validate([
            'title'=>'sometimes|string|max:150', 
            'isbn'=>'sometimes|string|max:20|unique:books,isbn', 
            'author_id'=>'sometimes|integer', 
            'category'=>'nullable|string|max:100',
            'stock'=>'sometimes|integer|min:0',
            'price'=>'sometimes|numeric|min:0.00|max:9999.99'
        ]);
        
        // 1. Actualizar el libro
        $book->update($request->all());

        // 2. Devolver el libro actualizado
        return response()->json([
            'message' => 'Book updated successfully.',
            'book' => new BookResource($book->load('author'))
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        // Devolver una respuesta sin contenido (204 No Content)
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
