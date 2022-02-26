<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\SearchValidationRules\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MultiSearchController extends Controller
{
    public function multiSearchFilter(Request $request){
        $resp=  array();
//        TODO Morning Brian ..Remember to sort by sponsorship;
        if($request->get('search_keyword')!= null && $request->get('search_price_range')!= null && $request->get('search_location') !=null){
            $validator = Validator::make(request()->all(),Rules::rules());
            if(!$validator->fails()){
                $prices = array_map('intval',explode("-",$request->search_price_range));

                $prices_query = Post::with(['image','reviews'])->where('price_from','>=',$prices[0])
                    ->where('price_to','<=',$prices[1]);

                $location_query = Post::with(['image','reviews'])->where('location','like','%'.$request->search_location.'%')
                    ->orWhere(function ($query) use ($request) {
                        $query->where('county','like','%'.$request->search_location.'%');
                    })->orWhere('sub_county','like','%'.$request->search_location.'%');

                $query = Post::with(['image','reviews'])->where('title','like','%'.$request->search_keyword.'%')
                    ->orWhere(function($query) use ($request) {
                        $query->where('description','like','%'.$request->search_keyword.'%');
                    })->union($prices_query)->union($location_query)->latest()->get();

                $resp['state'] =true;
                $resp['data'] =$query;

            }else{
                $resp['state'] =false;
                $resp['data'] = $validator->errors();
            }
//        TODO Morning Brian ..Remember to sort by sponsorship;
        }else if($request->get('search_keyword')!= null && $request->get('search_price_range')!= null){
            $validator =Validator::make(request()->all(),Rules::rules());
            if(!$validator->fails()){
                $prices = array_map('intval',explode("-",$request->search_price_range));

                $prices_query = Post::with(['image','reviews'])->where('price_from','>=',$prices[0])
                    ->where('price_to','<=',$prices[1]);

                $query = Post::with(['image','reviews'])->where('title','like','%'.$request->search_keyword.'%')
                    ->orWhere(function($query) use ($request) {
                        $query->where('description','like','%'.$request->search_keyword.'%');
                    })->union($prices_query)->latest()->get();

                $resp['state'] =true;
                $resp['data'] =$query;
            }else{
                $resp['state'] =false;
                $resp['data'] = $validator->errors();
            }

//        TODO Morning Brian ..Remember to sort by sponsorship;

        }else if($request->get('search_keyword') != null && $request->get('search_location')!=null){
            $validator =Validator::make(request()->all(),Rules::rules());
            if(!$validator->fails()){
                $location_query = Post::with(['image','reviews'])->where('location','like','%'.$request->search_location.'%')
                    ->orWhere(function ($query) use ($request) {
                        $query->where('county','like','%'.$request->search_location.'%');
                    })->orWhere('sub_county','like','%'.$request->search_location.'%');

                $query = Post::with(['image','reviews'])->where('title','like','%'.$request->search_keyword.'%')
                    ->orWhere(function($query) use ($request) {
                        $query->where('description','like','%'.$request->search_keyword.'%');
                    })->union($location_query)->latest()->get();

                $resp['state'] =true;
                $resp['data'] = $query;
            }else{
                $resp['state'] =false;
                $resp['data'] =$validator->errors();
            }
//
//        TODO Morning Brian ..Remember to sort by sponsorship;
        }else if($request->get('search_price_range')!= null && $request->get('search_location')!=null){
            $validator = Validator::make(request()->all(),Rules::rules());
            if(!$validator->fails()){
                $prices = array_map('intval',explode("-",$request->search_price_range));

                $prices_query = Post::with(['image','reviews'])->where('price_from','>=',$prices[0])
                    ->where('price_to','<=',$prices[1]);
                $query = Post::with(['image','reviews'])->where('location','like','%'.$request->search_location.'%')
                    ->orWhere(function ($query) use ($request) {
                        $query->where('county','like','%'.$request->search_location.'%');
                    })->orWhere('sub_county','like','%'.$request->search_location.'%')
                    ->union($prices_query)->latest()->get();

                $resp['state'] = true;
                $resp['data'] =$query;
            }else{
                $resp['state'] = false;
                $resp['data'] =$validator->errors();
            }


        }else{
            $resp['state'] = false;
            $resp['message'] = 'Define at least one search query';

        }

        return response()->json($resp);


    }
}
