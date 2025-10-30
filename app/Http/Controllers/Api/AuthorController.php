<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Models\Author;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all authors
        $authors = Author::orderBy('name')->paginate(5);
        return AuthorResource::collection($authors);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. data validate
        /* $request->validate([
            'name' => 'required|string|max:100',
            'nationality' => 'nullable|string|max:100',
            'birth_day' => 'nullable|date_format:Y-m-d',
        ]); */

        // 2. create author
        $author = Author::create($request->validate([
            'name' => 'required|string|max:100',
            'nationality' => 'nullable|string|max:100',
            'birth_day' => 'nullable|date_format:Y-m-d',
        ]));

        // 3. response resource
        //return new AuthorResource($author);
        return (new AuthorResource($author))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        // show all book by author
        $author->load('books');

        // response resource
        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        // 1. data validation
        $request->validate([
            'name' => 'sometimes|string|max:100',
            'nationality' => 'sometimes|nullable|string|max:100',
            'birth_day' => 'sometimes|nullable|date',
        ]);

        // 2. update author
        $author->update($request->all());

        // 3. response
        return new AuthorResource($author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $author->delete();

        // Devolver una respuesta sin contenido (204 No Content)
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Custom method: Display all books for a specific author.
     * Permitido para todos los roles.
     */
    public function books(Author $author)
    {
        // Get the author's book collection.
        $books = $author->books;

        // Return a collection of BookResource
        return BookResource::collection($books);
    }
}
