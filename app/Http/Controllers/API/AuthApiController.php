<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
 
class AuthApiController extends Controller
{
   
    public function register(Request $request) {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|max:191|unique:users,email',
            'password'=>'required|min:6|max:20'
        ]);
        if($validator->fails()){
            return response()->json([
                'validation_error' => $validator->message(),
            ]);
        }
        else{
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),

            ]);
            $token =  $user->createToken($user->email.'__Token')->plainTextToken;

            return response()->json([
                'status'=>200,
                'username'=>$user->name,
                'token'=>$token,
                'message'=>'Register Successfully'
            ]);
        }
    } 
}
