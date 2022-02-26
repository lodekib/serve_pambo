<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BraidsandWigsController extends Controller
{
    public function braids_and_wigs(){
        $conditioners_and_shampoos = Post::with(['image','reviews'])->where('title','like','%hair conditioners%')->
            OrWhere('description','like','%hair conditioners%')->orderByDesc('sponsorship')->get();

        $hair_serums = Post::with(['image','reviews'])->where('title','like','%hair serum%')->
          OrWhere('description','like','%hair serum%')->orderByDesc('sponsorship')->get();

        $hair_bands= Post::with(['image','reviews'])->where('title','like','%hair band%')
            ->OrWhere('description','like','%hair band%')->orderByDesc('sponsorship')->get();

        $frontal_wigs= Post::with(['image','reviews'])->where('title','like','%frontal wig%')
            ->OrWhere('description','like','%frontal wig%')->orderByDesc('sponsorship')->get();

        $dread_locks= Post::with(['image','reviews'])->where('title','like','%dread lock%')
           ->OrWhere('description','like','%dread lock%')->orderByDesc('sponsorship')->get();

        $wig_extensions= Post::with(['image','reviews'])->where('title','like','%wig extension%')
          ->OrWhere('description','like','%wig extension%')->orderByDesc('sponsorship')->get();

        $artificial_braids= Post::with(['image','reviews'])->where('title','like','%artificial braids%')
            ->OrWhere('description','like','%artificial braids%')->orderByDesc('sponsorship')->get();



        return response()->json([
            'Conditioners and Shampoos'=>$conditioners_and_shampoos,
            'Hair Serums'=>$hair_serums,
            'Hair Bands'=>$hair_bands,
            'Frontal Wigs'=>$frontal_wigs,
            'Dread Locks'=>$dread_locks,
            'Wig Extensions'=>$wig_extensions,
            'Artificial Braids'=>$artificial_braids,
        ]);
    }
}
