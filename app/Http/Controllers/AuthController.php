<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;  


class AuthController extends Controller
{

    public function login(Request $request)  
    {  
        $credentials = $request->validate([  
            'email' => 'required|email',  
            'password' => 'required',  
        ]);  

        
        if (Auth::attempt($credentials)) {  
                        $request->session()->regenerate();
  return redirect()->intended('dashboard');
            // $user = Auth::user();  
            // $token = $user->createToken('authToken')->accessToken;
            // 
            // $token = $user->createToken('authToken')->plainTextToken;  
            // $request->session()->regenerate();
            // return  response()->json(['token' => $token]);  
        }   

        return response()->json(['message' => 'Ошибка авторизации'], 401);  
    }

    public function logout(Request $request)  
    {
        Auth::logout();
    }
}
