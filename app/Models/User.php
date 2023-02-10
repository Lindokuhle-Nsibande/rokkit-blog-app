<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SebastianBergmann\CodeUnit\FunctionUnit;

class User extends Authenticatable
{
    // use HasApiTokens, HasFactory, Notifiable;

    public function blogs(){
        return $this->hasMany(Blog::class);
    }
    public function store($name, $surname, $email, $phone, $password){
        $this->name =  $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = Hash::make($password);
        cache()->forget('users');
        return $this->save();
    }
    public function getAllUsers(){
        return cache()->remember('users', now()->years(), function(){
            return User::with(['blogs'])->get();
        });
    }
}
