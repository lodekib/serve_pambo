<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{



    public function login(){
        if(Auth::attempt(['email' => request('email'),'password' => request('password')])){
            $user =  Auth::user();
            $success['token'] = $user->createToken('Pambo Login User Token')->accessToken;
            return response()->json([
                'success' => true,
                'token' => $success,
                'user' => $user,
                'message' =>'Login Succesful'
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Invalid User Credentials',
            ],401);
        }
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required|unique:users|regex:/[0-9]{10}/',
            'id_number' => 'required|unique:users|regex:/[0-9]/',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'success' =>false,
                'message' => $validator->errors(),
            ],401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('Pambo Register User Token')->accessToken;

        if(Auth::attempt(['email' => request('email'),'password' => request('password')])){
            return response()->json([
                'success' => true,
                'user' =>$user,
                'message' => 'Registered Successfully',
                'token' => $success,
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Registered Failed'
            ]);
        }

    }


    public function logout()
    {
        if (Auth::user()) {
            $user = Auth::user()->token();
            $user->revoke();

            return response()->json([
                'success' => true,
                'message' => 'Logout successfully'
            ]);
        }else {
            return response()->json([
                'success' => false,
                'message' => 'Unable to Logout User'
            ]);
        }
    }
}
