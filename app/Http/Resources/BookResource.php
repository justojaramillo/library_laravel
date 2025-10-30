<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{

    /**
     * Propiedad para eliminar el wrapper 'data' de las respuestas de un solo recurso.
     * @var string|null
     */
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'book_id' => $this->book_id,
            'title' => $this->title,
            'isbn' => $this->isbn,
            'category' => $this->category,
            'stock' => $this->stock,
            'price' => number_format($this->price, 2), // Formatea el precio a 2 decimales
            
            // Incluye el Autor: solo si la relación 'author' está cargada
            // Esto utiliza el AuthorResource para asegurar que la información del autor
            // se devuelva con el formato correcto y seguro.
            'author' => new AuthorResource($this->whenLoaded('author')),

            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            //'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
