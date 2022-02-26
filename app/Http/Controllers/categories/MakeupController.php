<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class MakeupController extends Controller
{
    public function makeup(){
        $foundations = Post::with(['image','reviews'])->where('title','like','%foundation%')->orWhere('description','like','%foundation%')->orderByDesc('sponsorship')->get();
        $highlights = Post::with(['image','reviews'])->where('title','like','%highlight%')->orWhere('description','like','%highlight%')->orderByDesc('sponsorship')->get();
        $lip_gloss= Post::with(['image','reviews'])->where('title','like','%lip gloss%')->orWhere('description','like','%lip gloss%')->orderByDesc('sponsorship')->get();
        $nail_polish= Post::with(['image','reviews'])->where('title','like','%nail polish%')->orWhere('description','like','%nail polish%')->orderByDesc('sponsorship')->get();
        $rouge_blusher= Post::with(['image','reviews'])->where('title','like','%rouge blusher%')->orWhere('description','like','%rouge blusher%')->orderByDesc('sponsorship')->get();
        $lip_balm_primers_sticks= Post::with(['image','reviews'])->where('title','like','%balm,primers,sticks%')->orWhere('description','like','%balm,primers,sticks%')->orderByDesc('sponsorship')->get();
        $makeup_removal= Post::with(['image','reviews'])->where('title','like','%makeup removal%')->orWhere('description','like','%makeup removal%')->orderBy('sponsorship')->get();
        $concealers= Post::with(['image','reviews'])->where('title','like','%concealer%')->orWhere('description','like','%concealer%')->orderByDesc('sponsorship')->get();
        $contour_powders_creams= Post::with(['image','reviews'])->where('title','like','%creams powders contour%')->orWhere('description','like','%creams powders contour%')->orderByDesc('sponsorship')->get();
        $eyelashes= Post::with(['image','reviews'])->where('title','like','%eye lash%')->orWhere('description','like','%eye lash%')->orderByDesc('sponsorship')->get();
        $eyebrow_pencils= Post::with(['image','reviews'])->where('title','like','%eyebrow pencils%')->orWhere('description','like','%eyebrow pencils%')->orderByDesc('sponsorship')->get();


        return response()->json([
            'Foundations'=>$foundations,
            'Highlights'=>$highlights,
            'Lip Gloss'=>$lip_gloss,
            'Nail Polish'=>$nail_polish,
            'Rouge Blushers'=>$rouge_blusher,
            'Lip Balm,Primers and Sticks'=>$lip_balm_primers_sticks,
            'Makeup Removal'=>$makeup_removal,
            'Concealers'=>$concealers,
            'Contour Powder Creams'=>$contour_powders_creams,
            'Eye Lashes'=>$eyelashes,
            'Eyebrow Pencils'=>$eyebrow_pencils
        ]);
    }
}
