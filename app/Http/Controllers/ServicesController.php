<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function all_services(){
        $all_services = Post::with(['image','reviews'])
            ->orderByDesc('sponsorship')->get();

        return response()->json($all_services);
    }
}
