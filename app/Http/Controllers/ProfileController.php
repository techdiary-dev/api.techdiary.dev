<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UpdateBasicProfileSettingsRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\User\UserDetailsResource;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Currently logged-in user
     * @return User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function me()
    {
        return auth()->user();
    }

    /**
     * User profile details
     * @param User $user
     * @return UserDetailsResource
     */
    public function profileDetails(User $user)
    {
        return new UserDetailsResource($user);
    }


    public function updateProfile(UpdateProfileRequest $request)
    {
        auth()
            ->user()
            ->update($request->all());

        return response()->json([
            "message" => "Profile Updated successfully"
        ]);
    }
}