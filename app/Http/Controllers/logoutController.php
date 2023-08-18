<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class logoutController extends Controller
{
    public function logout(Request $request, User $user) 
    {
        $user->tokens()->delete();

        return response()->json('Successfully logged out');
    }
}
