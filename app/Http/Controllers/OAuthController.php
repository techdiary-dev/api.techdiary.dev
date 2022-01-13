<?php

namespace App\Http\Controllers;

use App\Events\NewUserCreated;
use App\Models\User;
use App\Models\UserSocial;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

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
                ["service", $service],
                ["service_uid", $socialServiceUser->id],
            ])->first();

            if ($social_user) {
                $user = $social_user->user;
            } elseif (
                !($user = User::whereEmail($socialServiceUser->email)->first())
            ) {
                $user = new User([
                    "username" =>
                        $socialServiceUser->nickname ??
                        strtolower(
                            explode("@", $socialServiceUser->email)[0] .
                            Str::random(4)
                        ),
                    "name" => $socialServiceUser->name ?? Str::random(6),
                    "email" => $socialServiceUser->email,
                    "profilePhoto" => $socialServiceUser?->avatar,
                    "bio" => collect($socialServiceUser->user)->has("bio")
                        ? $socialServiceUser->user["bio"]
                        : null,
                ]);

                if ($service == "github") {
                    $user->social_links = [
                        "github" =>
                            "https://github.com/" .
                            $socialServiceUser->nickname,
                    ];
                }
                $user->save();
            }

            if (!$social_user) {
                NewUserCreated::dispatch($user);
                $user->socialProviders()->create([
                    "service" => $service,
                    "service_uid" => $socialServiceUser->id,
                ]);
            }

            $signedRoute = URL::temporarySignedRoute(
                "signedLogin",
                now()->addMinutes(10),
                [
                    "user_id" => $user->id,
                ]
            );
            $signedToken = explode("?", $signedRoute)[1];

            $redirect_url =
                env("CLIENT_BASE_URL") . "/auth/oauth-callback?" . $signedToken;
            return redirect($redirect_url);
            return env("CLIENT_URL");
        } catch (InvalidStateException $e) {
            return $this->redirect(env("CLIENT_URL") . "?error=1");
        }
    }
}