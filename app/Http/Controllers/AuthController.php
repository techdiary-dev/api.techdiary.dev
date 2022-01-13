<?php
namespace App\Http\Controllers;

class AuthController extends Controller
{
    public function signedLogin()
    {
        $userId = request()->get("user_id");
        auth()->loginUsingId($userId);

        return response()->json([
            "message" => "Successfully logged in through cookie",
        ]);
    }
}