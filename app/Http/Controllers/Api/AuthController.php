<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        return response()->json([
            'message' => 'Register works'
        ]);
    }

    public function login(Request $request)
    {
        return response()->json([
            'message' => 'Login works'
        ]);
    }
}
