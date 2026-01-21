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
            $user = Auth::user();  
            $token = $user->createToken('authToken')->plainTextToken;  
            return response()->json(['token' => $token]);  
        }   

        return response()->json(['message' => 'Ошибка авторизации'], 401);  
    }

    public function logout(Request $request)  
    {
        Auth::logout();
    }

    public function changePassword(Request $request) {
        $user = $request->user();
        $request->validate([
            'current_password' => 'required|min:3',
            'password' => 'required|min:3|confirmed',
        ]);

        if (!password_verify($request->current_password, $user->password)) {
            return response()->json(['message'=>'Не верный пароль']);
        }
        $user->password = $request->password;
        $user->save();
    }
}
