<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class baseController extends Controller
{
    public function responseData($data, $message){
        $response= [
            'status'=> true,
            'data'=>$data,
            'message'=> $message, 
        ];
        
        return response()->json($response, 200);
    }

    public function errorResponse($error, $erorrespone=[], $code=404){
        $response=[
            'status'=>false,
            'data'=> $error
        ];
        if(!empty($erorrespone)){
            $response['data']= $erorrespone ;          
        }
        return response()->json($response, $code);       
    }

}