<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserDetailsResource;
use App\Http\Resources\User\UserListResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function me()
    {
        return auth()->user();
    }

    public function userDetails($username)
    {
        $user = User::where(DB::raw('LOWER(username)'), strtolower($username))->first();
        if (!$user) abort(404, 'প্রোফাইল খুঁজে পাওয়া যায়নি ');

        return new UserDetailsResource($user);
    }

    public function users()
    {
        $users = User::latest();
        return UserListResource::collection($users->paginate(request()->query('limit', 10)));
    }
}
