<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\SearchValidationRules\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public function searchOneFilter(Request $request){

        $feedback = array();
        if($request->get('search_keyword') != null){
            $validator = Validator::make(request()->all(),Rules::rules());
            if(!$validator->fails()){
//                    TODO: Hello Brian ..Remember to sort by sponsorship
                $query = Post::with(['image','reviews'])->where('title','like','%'.$request->search_keyword.'%')
                    ->orWhere(function($query) use ($request) {
                        $query->where('description','like','%'.$request->search_keyword.'%');
                    })->latest()->get();

                $feedback['state'] = true;
                $feedback['status'] = 'success';
                $feedback['data'] =$query;
            }else{
                $feedback['state'] = false;
                $feedback['status'] = 'fail';
                $feedback['message'] =$validator->errors();
            }

        } else if($request->get('search_price_range') != null){
//                TODO: Hello Brian ..Remember to sort  search results by sponsorship
            $validator = Validator::make(request()->all(),Rules::rules());
            if(!$validator->fails()){
                $prices = array_map('intval',explode("-",$request->search_price_range));

                $query = Post::with(['image','reviews'])->where('price_from','>=',$prices[0])
                    ->where('price_to','<=',$prices[1])->latest()->get();

                $feedback['state'] = true;
                $feedback['status'] = 'success';
                $feedback['data'] =$query;
            }else{
                $feedback['state'] = false;
                $feedback['status'] = 'fail';
                $feedback['message'] =$validator->errors;
            }
        } else if($request->get('search_location') != null){
//                TODO : Hello Brian ..Remember to sort search results  by sponsorship
            $validator = Validator::make(request()->all(),Rules::rules());
            if(!$validator->fails()){
                $query = Post::with(['image','reviews'])->where('location','like','%'.$request->search_location.'%')
                    ->orWhere(function ($query) use ($request) {
                        $query->where('county','like','%'.$request->search_location.'%');
                    })->orWhere('sub_county','like','%'.$request->search_location.'%')
                    ->latest()->get();
                $feedback['state'] = true;
                $feedback['status'] = 'success';
                $feedback['data'] =$query;
            }else{
                $feedback['state'] = false;
                $feedback['status'] = 'fail';
                $feedback['message'] =$validator->errors();
            }
        }else{
            $feedback['state'] =false;
            $feedback['status'] = 'fail';
            $feedback['message'] = 'Define at least one search query';
        }
        return response()->json($feedback);

    }
}
