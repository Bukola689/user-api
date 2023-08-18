<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function reset(Request $request, $token)
    {
        // Delete Token Older Than 1 min

        $formatted = Carbon::now()->subMinutes(3)->toDateTimeString();

        PasswordReset::where('created_at', '<=', $formatted)->delete();
         
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $passwordReset = PasswordReset::where('token', $token)->first();

        if(!$passwordReset) {
            return response()->json([
                'message' => 'Token Is Invalid Or Has Expire',
                'status' => 'Failed'
            ], 404);
        }

        $user = User::where('email', $passwordReset->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        // Delete Token After resetting Password

        PasswordReset::where('email', $request->email)->delete();

        return response()->json([
            'message' => 'Your Password Has Been Reset And Changed Successfully'
        ]);

    }
}
