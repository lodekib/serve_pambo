<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id','rating','reviewer_last_name','review'
    ];

    public function post(){
        return $this->belongsTo(Post::class);
    }
}
