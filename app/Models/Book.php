<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $primaryKey = 'book_id';
    
    protected $fillable = ['title', 'isbn', 'author_id', 'category', 'stock', 'price'];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];

    public function author(){
        return $this->belongsTo(Author::class, 'author_id','author_id');
    }
    public function loans(){
        return $this->hasMany(Loan::class, 'book_id', 'book_id');
    }
}
