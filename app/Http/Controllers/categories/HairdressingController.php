<?php

namespace App\Http\Controllers\categories;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HairdressingController extends Controller
{
    public function hairdressing(){
        $shaving = Post::with(['image','reviews'])->where('title','like','%shaving%')->orWhere('description','like','%shaving%')->orderByDesc('sponsorship')->get();
        $waxing = Post::with(['image','reviews'])->where('title','like','%waxing%')->orWhere('description','like','%waxing%')->orderByDesc('sponsorship')->get();
        $dye= Post::with(['image','reviews'])->where('title','like','%dye%')->orWhere('description','like','%dye%')->orderByDesc('sponsorship')->get();
        $super_cuts= Post::with(['image','reviews'])->where('title','like','%super cut%')->orWhere('description','like','%super cut%')->orderByDesc('sponsorship')->get();
        $braids= Post::with(['image','reviews'])->where('title','like','%braids%')->orWhere('description','like','%braids%')->orderByDesc('sponsorship')->get();
        $dread_locks= Post::with(['image','reviews'])->where('title','like','%dread locks%')->orWhere('description','like','%dread locks%')->orderByDesc('sponsorship')->get();

        return response()->json([
            'Shaving'=>$shaving,
            'Waxing'=>$waxing,
            'Dye'=>$dye,
            'Super cuts'=>$super_cuts,
            'Braids'=>$braids,
            'Dread Locks'=>$dread_locks,
        ]);
    }
}
