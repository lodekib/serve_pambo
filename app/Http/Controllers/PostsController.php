<?php

namespace App\Http\Controllers;

use App\Events\TransactionCreatedEvent;
use App\Models\Image;
use App\Models\Post;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostsController extends Controller
{


    public function getPostID(Post $post)
    {
        return $post->id;
    }



//
    public function store(Request $request)
    {

        $post = new  Post();
        $mpesa =new MpesaController();
        $validator = Validator::make(request()->all(), $this->rules());


        //validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $feedback= array();
            $post->id_number=auth()->user()->id_number;
            $post->category = $request->get('category');
            $post->title = $request->get('title');
            $post->county = $request->get('county');
            $post->sub_county = $request->get('sub_county');
            $post->location = $request->get('location');
            $post->price_from = $request->get('price_from');
            $post->price_to = $request->get('price_to');
            $post->email = auth()->user()->email;
            $post->phone = auth()->user()->phone;
            $post->description = $request->get('description');
            $post->sponsorship = $request->get('sponsorship');
//
            //Making the request to the payment API at this point
            $checkMpesa =json_decode($mpesa->stkPush($request->get('sponsorship'),
                '254'.substr(auth()->user()->phone,1)));

           //ResponseCode  0 means the transaction was successful hence
            if($checkMpesa->ResponseCode == 0){
                $merchantRequestID = $checkMpesa->MerchantRequestID;
                $checkoutRequestID = $checkMpesa->CheckoutRequestID;

             //Saving of the upload related data .
                //This should execute after the TransactionCreatedEvent has fired
                     if(Transaction::where('merchant_request_id','=',$merchantRequestID)
                         ->where('checkout_request_id','=',$checkoutRequestID)->exists()){
                         if ($post->save()) {
                             $photos = $request->file('images');
                             $imagepaths = [];
                             foreach($photos as $photo){
                                 Storage::disk('public')->put('uploads/'.$photo->getClientOriginalName(),file_get_contents($photo));
                                 $imagepaths[] = $photo->getClientOriginalName();
                             }
                             $image = new Image();
                             $image->url = json_encode($imagepaths);
                             $image->post_id = $post->id;
                             $image->save();

                             $feedback['status']= true;
                             $feedback['message'] = 'Post Uploaded Successfully';
                             $feedback['images'] = $imagepaths;
                             $feedback['user'] =auth()->user();
                             $feedback['statusCode'] = 200;
                         }

                     }else{
                         $feedback['status']= false;
                         $feedback['message'] = 'No payment completed';
                         $feedback['phone'] =auth()->user()->phone;
                         $feedback['sponsorship'] = $request->get('sponsorship');
                         //                     TODO: NO payment completed
                     }


            }else{
                $feedback['status']= false;
                $feedback['message'] = 'Unable to complete payment.Please try again';
//                 TODO:Morning Brian,Response here should be unable to post [payment didn't go through]

            }
            return response()->json($feedback);
        }

    }


//    public function store(Request $request)
//    {
//
//        $post = new  Post();
//        $mpesa = new MpesaController();
//        $validator = Validator::make(request()->all(), $this->rules());
//
//        if ($validator->fails()) {
//            return response()->json($validator->errors(), 422);
//        } else {
//            $feedback = array();
//            $post->id_number = auth()->user()->id_number;
//            $post->category = $request->get('category');
//            $post->title = $request->get('title');
//            $post->county = $request->get('county');
//            $post->sub_county = $request->get('sub_county');
//            $post->location = $request->get('location');
//            $post->price_from = $request->get('price_from');
//            $post->price_to = $request->get('price_to');
//            $post->email = auth()->user()->email;
//            $post->phone = auth()->user()->phone;
//            $post->description = $request->get('description');
//            $post->sponsorship = $request->get('sponsorship');
//
//
//            if ($post->save()) {
//                $photos = $request->file('images');
//                $imagepaths = [];
//                foreach ($photos as $photo) {
//                    Storage::disk('public')->put('uploads/' . $photo->getClientOriginalName(), file_get_contents($photo));
//                    $imagepaths[] = $photo->getClientOriginalName();
//                }
//                $image = new Image();
//                $image->url = json_encode($imagepaths);
//                $image->post_id = $post->id;
//                $image->save();
//
//                $feedback['status'] = true;
//                $feedback['message'] = 'Post Uploaded Successfully';
//                $feedback['images'] = $imagepaths;
//                $feedback['user'] = auth()->user();
//                $feedback['statusCode'] = 200;
//            }
//
//        }
//
//        return response()->json($feedback);
//    }


    public function rules(){
        return [
            'title'=>['required','string'],
            'category'=>['required','string'],
            'county'=>['required','string'],
            'sub_county'=>['required','string'],
            'location'=>['required','string'],
            'price_from'=>['required','string'],
            'price_to'=>['required','string'],
            'description'=>['required','string'],
            'sponsorship'=>['required'],
            'images.*'=>['required','image','mimes:jpg,png,jpeg','max:6048']
        ];
    }
}
