<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'image', 'description', 'status', 'view', 'genre_post_id', 'customer_id'];

    public function genrePost()
    {
        return $this->belongsTo(GenrePost::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
