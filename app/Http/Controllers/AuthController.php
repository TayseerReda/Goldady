<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $ValidatedData=$request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required'

        ]);
        $ValidatedData['password']=bcrypt($ValidatedData['password']);
        $user=User::Create($ValidatedData);
        

        $token=$user->createToken( $request->name);
        $response=[
           'name'=>$user->name, 
           'token'=> $token->plainTextToken
        ];
        return response()->json(['message'=>'User registered successfully','User'=>$response]);
        
    }


    public function login(Request $request)
    {
        $ValidatedData=$request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required'

        ]);
        $user=User::where('email',$ValidatedData['email'])->first();

        if($user && Hash::check($request->password, $user->password)){

            $token=$user->createToken($request->email);
            $response=[
               'name'=>$user->name, 
               'token'=> $token->plainTextToken
            ];
           
            return response()->json(['message'=>'User logined successfully','User'=>$response]);

        }
        else return response()->json(['message'=>'Invalid email or password']);


    }

 


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return [
            'message'=>'User loged out '
        ];

    }

}
