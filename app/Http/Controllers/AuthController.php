<?php

namespace App\Http\Controllers;

use App\Events\NewUserCreated;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateBasicProfileSettingsRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{

    /**
     * Register account
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function register(RegisterRequest $request)
//    {
//        $user = User::create($request->all(['name', 'username', 'email', 'password']));
//
//        return response()->json([
//            'message' => 'Registered successfully',
//            'user' => $user
//        ]);
//    }
//

    /**
     * Login using email and password
     * @param LoginRequest $request
     * @return array
     * @throws AuthenticationException
     */
//    public function getTokenUsingCredential(LoginRequest $request)
//    {
//        if (!auth()->guard()->attempt($request->all()))
//            throw new AuthenticationException('Invalid credential');
//
//        return [
//            'token' => Authentication::createToken(auth()->user())
//        ];
//    }

    /**
     * Authenticated user's tokens
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
//    public function myTokens()
//    {
//        return MyTokensResource::collection(auth()->user()->tokens);
//    }

//    public function revokeToken($id)
//    {
//        auth()->user()->tokens()->find($id)->delete();
//
//        return response()->json([
//            'message' => 'Token revoked successfully'
//        ]);
//    }

//    public function logout()
//    {
//        auth()->user()->currentAccessToken()->delete();
//
//        return response()->json([
//            'message' => 'Successfully logged out'
//        ]);
//    }

    /**
     *
     * @param $service
     * @return mixed
     */
    public function oauthRedirect($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    public function oauthCallback($service)
    {
        try {
            $socialServiceUser = Socialite::driver($service)->stateless()->user();

            $social_user = UserSocial::where([
                ['service', $service],
                ['service_uid', $socialServiceUser->id]
            ])->first();

            if ($social_user) $user = $social_user->user;
            else if (!$user = User::whereEmail($socialServiceUser->email)->first()) {

                $user = new User([
                    'username' => $socialServiceUser->nickname ?? strtolower(explode("@", $socialServiceUser->email)[0] . Str::random(4)),
                    'name' => $socialServiceUser->name ?? Str::random(6),
                    'email' => $socialServiceUser->email,
                    'profilePhoto' => $socialServiceUser?->avatar,
                    'bio' => collect($socialServiceUser->user)->has('bio') ? $socialServiceUser->user['bio'] : null,
                ]);

                if ($service == 'github') {
                    $user->social_links = [
                        'github' => 'https://github.com/' . $socialServiceUser->nickname
                    ];
                }
                $user->save();
            }

            if (!$social_user) {
                NewUserCreated::dispatch($user);
                $user->socialProviders()->create([
                    'service' => $service,
                    'service_uid' => $socialServiceUser->id
                ]);
            }

            $signedRoute = URL::temporarySignedRoute('oauth-signed-login', now()->addMinutes(10), [
                'user_id' => $user->id,
            ]);
            $signedToken = explode('?', $signedRoute)[1];



            $redirect_url = env('CLIENT_URL') . '/auth/oauth-callback?' . $signedToken;
            return redirect($redirect_url);

        } catch (InvalidStateException $e) {
            return $this->redirect(env('CLIENT_URL') . '?error=1');
        }
    }


    public function oauthSignedLogin(\Illuminate\Http\Request $request)
    {
        $userId = $request->get('user_id');
        auth()->loginUsingId($userId);

        return response()->json([
           'message' => 'Successfully logged in through cookie'
        ]);
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
