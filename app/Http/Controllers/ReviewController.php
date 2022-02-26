<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\SearchValidationRules\Rules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function storeReview(Request $request){
        $resp =[];
        $validator = Validator::make(request()->all(),Rules::reviewValidation());

        if(!$validator->fails()){
            $review = new Reviews();
            $review->post_id =$request->get('post_id');
            $review->rating = $request->get('rating');
            $review->reviewer_last_name = auth()->user()->last_name;
            $review->review = $request->get('review');

            if($review->save()){
                $resp['status'] =true;
                $resp['message']='Review Added Successfully';
            }else{
                $resp['status'] =false;
                $resp['message']='Unable to Add Review';
            }

        }else{
            $resp['status'] =false;
            $resp['message']='Unable to Add Review';

        }
        return response()->json($resp);


    }

    public function getReviews($post_id){
        $resp =[];
        $validator = Validator::make($post_id,['post_id'=>'required|string']);
        if($validator->fails()){
            $resp['status'] = false;
            $resp['message'] ='Unable to fetch reviews';
        }else{
            $reviews = Reviews::where('post_id','=',$post_id)->get();

            $resp['status'] = true;
            $resp['data'] =$reviews;

        }
        return response()->json($resp);

    }
}
