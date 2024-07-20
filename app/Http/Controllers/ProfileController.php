<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\User\UserDetailsResource;
use App\Http\Resources\User\UserListResource;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function updateMyProfile(UpdateProfileRequest $request): \Illuminate\Http\JsonResponse
    {
        auth()
            ->user()
            ->update($request->all());

        return response()->json([
            'message' => 'Profile Updated successfully',
        ]);
    }

    public function getUniqueUsername(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'username' => 'required',
        ]);

        $slugged_username = Str::slug($request->get('username'));
        $slugged_auth_username = Str::slug(auth()->user()->username);

        return response()->json([
            'username' => $slugged_auth_username == $slugged_username ? $slugged_username : $this->getUniqueUsernameUtil($request->username)
        ]);
    }

    public function getUniqueUsernameUtil(string $username): string
    {
        $slugged = Str::slug($username);
        $slugExists = User::where('username', $slugged)->first();
        if (!$slugExists) {
            return $slugged;
        }
        return $slugged . '-' . Str::random(5);
    }
}
