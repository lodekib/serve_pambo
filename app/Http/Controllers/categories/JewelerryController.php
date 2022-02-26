<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class JewelerryController extends Controller
{
    public function jewelerry(){
    $earings = Post::with(['image','reviews'])->where('title','like','%earrings%')
       ->OrWhere('description','like','%earings%')->orderByDesc('sponsorship')->get();

    $bracelets = Post::with(['image','reviews'])->where('title','like','%bracelet%')
        ->OrWhere('description','like','%bracelet%')->orderByDesc('sponsorship')->get();

    $necklaces= Post::with(['image','reviews'])->where('title','like','%necklace%')
        ->orWhere('description','like','%necklace%')->orderByDesc('sponsorship')->get();

    $bangles= Post::with(['image','reviews'])->where('title','like','%bangle%')
        ->OrWhere('description','like','%bangle%')->orderByDesc('sponsorship')->get();

    $belly_chains= Post::with(['image','reviews'])->where('title','like','%belly chain%')
        ->OrWhere('description','like','%belly chain%')->orderByDesc('sponsorship')->get();

    $body_piercing= Post::with(['image','reviews'])->where('title','like','%body piercing%')
        ->OrWhere('description','like','%body piercing%')->orderByDesc('sponsorship')->get();

    $tattoos_and_bodyart= Post::with(['image','reviews'])->where('title','like','%tattoos%')
      ->OrWhere('description','like','%tattoos%')->orderByDesc('sponsorship')->get();

    $engraving= Post::with(['image','reviews'])->where('title','like','%engraving%')
       ->OrWhere('description','like','%engraving%')->orderByDesc('sponsorship')->get();


    return response()->json([
        'Earrings'=>$earings,
        'Bracelets'=>$bracelets,
        'Necklaces'=>$necklaces,
        'Bangles'=>$bangles,
        'Belly Chains'=>$belly_chains,
        'Body Piercing'=>$body_piercing,
        'Tattoos and Body Art'=>$tattoos_and_bodyart,
        'Engravings'=>$engraving,
    ]);
}
}
