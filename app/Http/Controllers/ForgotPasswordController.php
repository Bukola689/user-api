<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function reset_password_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        //save the email

        $email = $request->email;

        // check user email if exist

        $user = User::where('email', $request->email)->first();
        if(!$user) {
            return response()->json([
                'message' => 'Email Does Not Exist',
                'status' => 'Failed'
            ], 404);
        }

        //Generate Token

        $token = Str::random(60);

        //save data to password reset table

        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        //dump("https//127.0.0.1:3000/api/user/reset" . $token);

        //sending email with password reset view

        Mail::send('reset', ['token' => $token], function(Message $message) use($email) {
            $message->subject('Reset Your Password');
            $message->to($email);
        });

        return response()->json([
            'message' => 'Password Reset Sent Check Your Email And Proceed',
            'status' => 'success'
        ], 200);
    }
}
