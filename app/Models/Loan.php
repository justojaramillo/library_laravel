<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $primaryKey = 'loan_id';
    protected $fillable = ['book_id','user_id','loan_date','return_date','returned'];

    protected $casts = [
        'loan_date' => 'date',
        'return_date' => 'date',
        'returned' => 'boolean',
    ];

    public function book(){
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
