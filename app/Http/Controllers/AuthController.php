<?php

namespace App\Http\Controllers;

use App\Events\NewUserCreated;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateBasicProfileSettingsRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\MyTokensResource;
use App\Models\User;
use App\Models\UserSocial;
use App\TechDiary\Authentication;
use Illuminate\Auth\AuthenticationException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{

    /**
     * Register account
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all(['name', 'username', 'email', 'password']));

        return response()->json([
            'message' => 'Registered successfully',
            'user' => $user
        ]);
    }

    /**
     * Login using email and password
     * @param LoginRequest $request
     * @return array
     * @throws AuthenticationException
     */
    public function login(LoginRequest $request)
    {
        if (!auth()->guard()->attempt($request->all()))
            throw new AuthenticationException('Invalid credential');

        return [
            'token' => Authentication::createToken(auth()->user())
        ];
    }

    /**
     * Authenticated user's tokens
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function myTokens()
    {
        return MyTokensResource::collection(auth()->user()->tokens);
    }

    public function revokeToken($id)
    {
        auth()->user()->tokens()->find($id)->delete();

        return response()->json([
            'message' => 'Token revoked successfully'
        ]);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function redirect($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function callback($service)
    {
        try {

            $serviceUser = Socialite::driver($service)->stateless()->user();

            $user = null;
            // Check if this service already exists
            $social_user = UserSocial::where([
                ['service', $service],
                ['service_uid', $serviceUser->id]
            ])->first();

            if ($social_user) $user = $social_user->user;
            else if (!$user = User::whereEmail($serviceUser->email)->getModel()) {
                $user = User::create([
                    'username' => $serviceUser->nickname,
                    'name' => $serviceUser->name ?? Str::random(6),
                    'email' => $serviceUser?->email,
                    'profilePhoto' => $serviceUser?->avatar,
                    'bio' => $serviceUser?->user && $serviceUser?->user['bio'],
                    'social_links' => [
                        'github' => 'https://github.com/' . $serviceUser->nickname
                    ]
                ]);
            }

            if (!$social_user) {
                NewUserCreated::dispatch($user);
                $user->socialProviders()->create([
                    'service' => $service,
                    'service_uid' => $serviceUser->id
                ]);
            }

            $redirect_url = env('CLIENT_URL') . '/social-callback?token=' . Authentication::createToken($user);
            return redirect($redirect_url);

        } catch (InvalidStateException $e) {
            return $this->redirect(env('CLIENT_URL') . '?error=1');
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        auth()->user()->update($request->all());

        return response()->json([
            'message' => 'Profile Updated successfully',
            'data' => auth()->user()
        ]);
    }

    /**
     * Update basic profile settings
     * @param UpdateBasicProfileSettingsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBasicProfileSettings(UpdateBasicProfileSettingsRequest $request)
    {
        auth()->user()->update($request->all());

        return response()->json([
            'message' => 'Profile Updated successfully',
            'data' => auth()->user()
        ]);
    }

}
