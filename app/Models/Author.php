<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    use HasFactory;

    protected $primaryKey = 'author_id';

    protected $fillable = ['name', 'nationality','birth_day'];

    protected $casts = ['birth_day' => 'date'];

    public function books(){
        return $this->hasMany(Book::class, 'author_id', 'author_id');
    }
}
