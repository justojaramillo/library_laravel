<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
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
            'author_id' => $this->author_id,
            'name' => $this->name,
            'nationality' => $this->nationality,
            'birth_day' => $this->birth_day,
            
            // Campo calculado: Cuenta los libros de este autor.
            'books_count' => $this->books()->count(),
            
            // Incluye los libros asociados SOLO si la relación 'books' fue precargada (eager loaded).
            // Esto evita problemas de N+1 y asegura que BookResource formatee los datos.
            'books' => BookResource::collection($this->whenLoaded('books')),

            // Marcas de tiempo formateadas
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            //'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
