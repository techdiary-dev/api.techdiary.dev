<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\GenerateTokenRequest;
use App\Http\Requests\Auth\OAuthTokenGrantRequest;
use App\Models\User;
use App\Models\UserSocial;
use App\TechDiary\TechdiaryToken;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Nette\NotImplementedException;

class OAuthController extends Controller
{
    public function redirect($service)
    {
        return Socialite::driver($service)
            ->stateless()
            ->redirect();
    }

    public function callback($service)
    {
        try {
            $socialServiceUser = Socialite::driver($service)
                ->stateless()
                ->user();

            $social_user = UserSocial::where([
                ['service', $service],
                ['service_uid', $socialServiceUser->id],
            ])->first();

            if ($social_user) {
                $user = $social_user->user;
            } elseif (
                ! ($user = User::whereEmail($socialServiceUser->email)->first())
            ) {
                $user = new User([
                    'username' => $socialServiceUser->nickname ??
                        strtolower(
                            explode('@', $socialServiceUser->email)[0].
                            Str::random(4)
                        ),
                    'name' => $socialServiceUser->name ?? Str::random(6),
                    'email' => $socialServiceUser->email,
                    'profilePhoto' => $socialServiceUser?->avatar,
                    'bio' => collect($socialServiceUser->user)->has('bio')
                        ? $socialServiceUser->user['bio']
                        : null,
                ]);

                if ($service == 'github') {
                    $user->social_links = [
                        'github' => 'https://github.com/'.
                            $socialServiceUser->nickname,
                    ];
                }
                $user->save();
            }

            if (! $social_user) {
                $user->socialProviders()->create([
                    'service' => $service,
                    'service_uid' => $socialServiceUser->id,
                ]);
            }

            $signedRoute = URL::temporarySignedRoute(
                'signedLogin',
                now()->addMinutes(10),
                [
                    'user_id' => $user->id,
                ]
            );
            $signedToken = explode('?', $signedRoute)[1];

            $redirect_url =
                env('CLIENT_BASE_URL').'/auth/oauth-callback?'.$signedToken;

            return redirect($redirect_url);
        } catch (InvalidStateException $e) {
            return $this->redirect(env('CLIENT_URL').'?error=1');
        }
    }

    public function createTokenUsingSecret(GenerateTokenRequest $request)
    {
        $social_user = UserSocial::where([
            ['service', $request->oauth_provider],
            ['service_uid', $request->oauth_uid],
        ])->first();

        if ($social_user) {
            $token = TechdiaryToken::createTokenWithClientInformation($social_user->user);

            return response()->json([
                'access_token' => $token,
            ]);
        }

        $username = strtolower(
            explode('@', $request->email)[0].
            Str::random(4)
        );

        $user = new User([
            'name' => $request->name,
            'username' => $username,
            'email' => $request->email,
            'profilePhoto' => $request->image,
        ]);
        $user->save();

        $user->socialProviders()->create([
            'service' => $request->oauth_provider,
            'service_uid' => $request->oauth_uid,
        ]);

        $token = TechdiaryToken::createTokenWithClientInformation($user);

        return response()->json([
            'access_token' => $token,
        ]);
    }

    public function grantToken(OAuthTokenGrantRequest $request)
    {
        switch ($request->grant_type) {
            case 'password':
                if (! $request->email || ! $request->password) {
                    abort(403, 'Email and password are required for grant_type password');
                }

                return response()->json([
                    'message' => "Successfully granted token using grand_type: $request->grant_type",
                    'access_token' => $this->grantTokenUsingPassword($request->email, $request->password),
                ]);
            case 'refresh_token':
                throw new NotImplementedException('Refresh token is not implemented');
            case 'authorization_code':
                throw new NotImplementedException('Authorization code is not implemented');
                break;
        }
    }

    public function grantTokenUsingPassword(string $email, string $password)
    {
        $user = User::whereEmail($email)->first();

        if (! $user) {
            abort(403, 'Invalid credentials');
        }

        $attempt = auth()->attempt(['email' => $email, 'password' => $password]);

        if (! $attempt) {
            // throw UnauthorizedException::withMessage('Invalid credentials');
            abort(403, 'Invalid credentials');
        }

        return TechdiaryToken::createTokenWithClientInformation($user);
    }
}
