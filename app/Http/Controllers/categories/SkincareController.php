<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class SkincareController extends Controller
{
    public function skincare(){
        $age_spots = Post::with(['image','images'])->where('title','like','%age spots%')->orWhere('description','like','%age spots%')->orderByDesc('sponsorship')->get();
        $chemical_peeling = Post::with(['image','images'])->where('title','like','%chemical peeling%')->orWhere('description','like','%chemical peeling%')->orderByDesc('sponsorship')->get();
        $laser_resurfacing= Post::with(['image','images'])->where('title','like','%laser resurfacing%')->orWhere('description','like','%laser resurfacing%')->orderByDesc('sponsorship')->get();
        $skin_rejuvenation= Post::with(['image','images'])->where('title','like','%skin rejuvenation%')->orWhere('description','like','%skin rejuvenation%')->orderByDesc('sponsorship')->get();
        $acne_light_therapy= Post::with(['image','images'])->where('title','like','%acne light therapy%')->orWhere('description','like','%acne light therapy%')->orderByDesc('sponsorship')->get();
        $thermage= Post::with(['image','images'])->where('title','like','%thermage%')->orWhere('description','like','%thermage%')->orderByDesc('sponsorship')->get();

        return response()->json([
            'Age Spots Removal'=>$age_spots,
            'Chemical Peeling'=>$chemical_peeling,
            'Laser Resurfacing'=>$laser_resurfacing,
            'Skin Rejuvenation'=>$skin_rejuvenation,
            'Acne Light Therapy'=>$acne_light_therapy,
            'Thermage'=>$thermage,
        ]);
    }
}
