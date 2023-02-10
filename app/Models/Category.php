<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function blogs(){
        return $this->hasMany(Blog::class);
    }
    public function getAllCategory(){
        return cache()->remember('category', now()->years(), function(){
            return Category::all();
        });
    }
}
