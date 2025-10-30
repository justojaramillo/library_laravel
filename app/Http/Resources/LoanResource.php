<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
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
            'loan_id' => $this->loan_id,
            'loan_date' => $this->loan_date->format('Y-m-d'),
            'return_date' => $this->return_date ? $this->return_date->format('Y-m-d') : null,
            'returned' => (bool) $this->returned,
            
            // Incluir el libro (eager loaded)
            'book' => new BookResource($this->whenLoaded('book')),

            // Incluir el usuario (solo si está cargado, generalmente para el Admin)
            //'user' => new UserResource($this->whenLoaded('user')),
            'user' => new UserResource($this->user),
            
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            //'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
