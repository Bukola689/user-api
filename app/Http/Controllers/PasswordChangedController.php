<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordChangedController extends Controller
{
    public function changePassword(Request $request)
    {

        $user = User::first();

        $data = Validator::make($request->all(), [
            "old_password" => "required",
            "password" => "required",
            "confirm_password" => "required|same:password"
           ]);
    
           if($data->fails()) {
            return response()->json([
                'message'=> 'check your passwords for validation'], 422);
           }
    
           $user = $request->user();
    
            if( Hash::check($request->old_password, $user->password)){
               
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
    
               return response()->json([
                  'message'=> 'Password Updated Successfully',
               ], 200);
    
            } else {
                return response()->json([
                    'message' => 'old password does no match !'
                ], 401);
             }
    }
}
