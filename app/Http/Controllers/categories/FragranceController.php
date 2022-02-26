<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class FragranceController extends Controller
{
    public function fragrance(){
        $body_sprays = Post::with(['image','reviews'])->where('title','like','%body spray%')
            ->orWhere('description','like','%body spray%')
            ->orderByDesc('sponsorship')->get();
        $deodorants = Post::with(['image','reviews'])->where('title','like','%deodorant%')->orWhere('description','like','%deodorant%')
            ->orderByDesc('sponsorship')->get();

        $perfumes= Post::with(['image','reviews'])->where('title','like','%perfume%')
            ->orWhere('description','like','%perfume%')->orderByDesc('sponsorship')->get();

        $air_fresheners= Post::with(['image','reviews'])->where('title','like','%air freshener%')
            ->orWhere('description','like','%air freshener%')->orderByDesc('sponsorship')->get();

        $citrus= Post::with(['image','reviews'])->where('title','like','%citrus%')
            ->orWhere('description','like','%citrus%')->orderByDesc('sponsorship')->get();

        $fruity= Post::with(['image','reviews'])->where('title','like','%fruity%')
            ->orWhere('description','like','%fruity%')->orderByDesc('sponsorship')->get();

        $floral= Post::with(['image','reviews'])->where('title','like','%floral%')
            ->orWhere('description','like','%floral%')->orderByDesc('sponsorship')->get();

        $woody= Post::with(['image','reviews'])->where('title','like','%woody%')
            ->orWhere('description','like','%woody%')->orderByDesc('sponsorship')->get();

        return response()->json([
            'Body Sprays'=>$body_sprays,
            'Deodorants'=>$deodorants,
            'Perfumes'=>$perfumes,
            'Air Fresheners'=>$air_fresheners,
            'Citrus'=>$citrus,
            'Fruity'=>$fruity,
            'Floral'=>$floral,
            'Woody'=>$woody,
        ]);

    }
}
