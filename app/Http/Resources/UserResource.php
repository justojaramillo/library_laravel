<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            // Usamos user_id como llave primaria, según tu esquema.
            'user_id' => $this->user_id, 
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            //'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
