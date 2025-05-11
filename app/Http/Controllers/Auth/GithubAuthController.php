<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GithubAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function callback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
            
            $user = User::updateOrCreate([
                'github_id' => $githubUser->id,
            ], [
                'name' => $githubUser->name ?? $githubUser->nickname,
                'email' => $githubUser->email,
                'password' => bcrypt(Str::random(24)),
            ]);

            Auth::login($user);

            return redirect('/');
            
        } catch (\Exception $e) {
            return redirect('/')->withErrors('GitHub authentication failed');
        }
    }
}