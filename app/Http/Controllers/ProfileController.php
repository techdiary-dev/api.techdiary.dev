<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\User\UserDetailsResource;
use App\Http\Resources\User\UserListResource;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * List of all users
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function users()
    {
        $users = User::latest();

        return UserListResource::collection($users->paginate(request()->query('limit', 10)));
    }

    /**
     * Currently logged-in user
     *
     * @return User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function me()
    {
        return auth()->user();
    }

    /**
     * User profile details
     *
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
            'message' => 'Profile Updated successfully',
        ]);
    }
}
