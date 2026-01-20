<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProfileController extends Controller
{
    public function index(Request $request)
    {
        try {
            return $request->user();
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
    
}
