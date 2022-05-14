<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\baseController as baseController;
use App\Models\User as User;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\Hash;

class registerController extends baseController
{
    public function register(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'name'=> 'required',
            'email'=> 'required|email',
            'password'=> 'required',
            'c_password'=> 'required|same:password'
        ]);
        // if the valdation is Errors
        if ($validator->fails()) 
        {
            return $this->errorResponse("Error in Register",$validator->errors());       
        }

        // make encrypt the password using Hash class
        $input= $request->all();
        $input['password']= Hash::make($input['password']);
        
        // create new user
        $user= User::create($input);

        // create Token for the user and get name 
        $success['token']= $user->createToken('Mohammad')->plainTextToken;
        $success['name']= $user->name;

        return $this->responseData($success, 'User registered successfully');       
    }

    public function login(Request $request)
    {
       if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user= Auth::user();
            $success['token']= $user->createToken('Mohammad')->plainTextToken;
            $success['name']= $user->name;

            return $this->responseData($success, 'User login successfully ');
        }
        else
        {
            return $this->errorResponse('Unauthorised',['error'=>'Unauthorised']);     
        }
            
        
    }
}