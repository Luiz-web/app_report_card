<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        //auntentication (email and password)
        $credentials = $request->all(['email', 'password']);
        $token = auth('api')->attempt($credentials);
        
        if($token) { // User authenticated successfully
            return response()->json(['token' => $token]);
        
        } else { // error with email or password
            return response()->json(['error' => 'email or password invalid'], 403);
        }
        
        //return one token jwt
        return 'login';
    }

    public function logout() {
        auth('api')->logout();
        return response()->json(['msg' => 'Logout successfully']); 
    }

    public function refresh() {
        $token = auth('api')->refresh();  // client forward a valid jwt
        return response()->json(['token' => $token]); 
    }

    public function me() {
        return response()->json(auth()->user());
    }
}
