<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Post extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id_number','category',
        'title','county','sub_county','location',
        'price_from','price_to','email','phone','description',
        'sponsorship'
        ];

    public function image(){
        return $this->hasOne(Image::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function reviews(){
        return $this->hasMany(Reviews::class);
    }
}
