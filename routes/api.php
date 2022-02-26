<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'],function(){
    Route::post('/login','App\Http\Controllers\UsersController@login');
    Route::post('/register','App\Http\Controllers\UsersController@register');
    Route::get('/logout','App\Http\Controllers\UsersController@logout')->middleware('auth:api');
    //post service
    Route::post('/post','App\Http\Controllers\PostsController@store')->middleware('auth:api');
    //fetch services
    Route::get('/all/services','App\Http\Controllers\ServicesController@all_services');
    Route::get('/fragrance/services','App\Http\Controllers\categories\FragranceController@fragrance');
    Route::get('/braids&wigs/services','App\Http\Controllers\categories\BraidsandWigsController@braids_and_wigs');
    Route::get('/hairdressing/services','App\Http\Controllers\categories\HairdressingController@hairdressing');
    Route::get('/jewelerry/services','App\Http\Controllers\categories\JewelerryController@jewelerry');
    Route::get('/makeup/services','App\Http\Controllers\categories\MakeupController@makeup');
    Route::get('/massage/services','App\Http\Controllers\categories\MassageController@massage');
    Route::get('/skincare/services','App\Http\Controllers\categories\SkincareController@skincare');
    //search for service
    Route::post('/single_search','App\Http\Controllers\SearchController@searchOneFilter');
    Route::post('/multi_search','App\Http\Controllers\MultiSearchController@multiSearchFilter');

//    TODO: Remember to remove the access_token and the register_urls routes before pushing into production [security concern]
    Route::get('/access_token','App\Http\Controllers\MpesaController@accessToken');
    Route::post('/stk_push','App\Http\Controllers\MpesaController@stkPush');
    Route::post('/register_urls','App\Http\Controllers\MpesaController@registerURLS');

    Route::post('/add_review','App\Http\Controllers\ReviewController@storeReview');
    Route::get('/service_reviews/{post_id}','App\Http\Controllers\ReviewController@getReviews');

});


Route::group(['prefix' =>'pambo_v1'],function(){
    Route::post('/confirmation','App\Http\Controllers\RespondToMpesaController@confirmation');
    Route::post('/validation','App\Http\Controllers\RespondToMpesaController@validation');

});

