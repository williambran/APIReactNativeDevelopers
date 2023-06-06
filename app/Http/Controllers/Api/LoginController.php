<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Model\User;  //archis agregado para aute
use Illuminate\Support\Facades\Auth; //archis agregado para aute

class LoginController extends Controller
{
    //

    public function login(Request $request) {
        //validate si info login es correcto
        $this->validateLogin($request);
        if (Auth::attempt($request->only('email','password'))) {

            $user= Auth::user();
            $tokenResult =  $user->createToken($request->name);
            $token = $tokenResult->token;

            if ($request->remember_me){
                $token->expires_at = Carbon::now()->addWeeks(1);
                
            }
            $token->save();
            return response()->json([
                'token' => $tokenResult->accessToken,
                'message' => 'Success',
                'expired_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    public function validateLogin(Request $request){
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    }
}
