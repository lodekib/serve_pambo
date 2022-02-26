<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class MassageController extends Controller
{
    public function massage(){
        $hot_stone_massage = Post::with(['image','reviews'])->where('title','like','%hot stone massage%')->orWhere('description','like','%hot stone massage%')->orderByDesc('sponsorship')->get();
        $sports_massage = Post::with(['image','reviews'])->where('title','like','%sports massage%')->orWhere('description','like','%sports massage%')->orderByDesc('sponsorship')->get();
        $swedish_massage= Post::with(['image','reviews'])->where('title','like','%swedish massage%')->orWhere('description','like','%swedish massage%')->orderByDesc('sponsorship')->get();
        $aromatherapy= Post::with(['image','reviews'])->where('title','like','%aroma therapy%')->orWhere('description','like','%aroma therapy%')->orderByDesc('sponsorship')->get();
        $deep_tissue= Post::with(['image','reviews'])->where('title','like','%deep tissue%')->orWhere('description','like','%deep tissue%')->orderByDesc('sponsorship')->get();
        $reflexology= Post::with(['image','reviews'])->where('title','like','%reflexology%')->orWhere('description','like','%reflexology%')->orderByDesc('sponsorship')->get();
        $prenatal= Post::with(['image','reviews'])->where('title','like','%prenatal%')->orWhere('description','like','%prenatal%')->orderByDesc('sponsorship')->get();

        return response()->json([
            'Hot Stone Massage'=>$hot_stone_massage,
            'Sports Massage'=>$sports_massage,
            'Swedish Massage'=>$swedish_massage,
            'Aromatherapy'=>$aromatherapy,
            'Deep Tissue'=>$deep_tissue,
            'Reflexology'=>$reflexology,
            'Prenatal'=>$prenatal,
        ]);
    }
}
