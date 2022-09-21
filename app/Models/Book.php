<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'author'];

    public function libraries() {
        return $this->belongsToMany(Library::class);
    }

    public function votedUsers() {
        return $this->belongsToMany(User::class, 'likes')->withPivot('is_dislike')->withTimestamps();
    }
}
