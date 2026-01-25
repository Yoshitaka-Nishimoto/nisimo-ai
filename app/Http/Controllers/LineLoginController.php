<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LineLoginController extends Controller
{
    /**
     * Redirect the user to the LINE authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToLine()
    {
         \Log::debug('LINE redirectTo: ');
        return Socialite::driver('line')->with(['scope' => 'profile openid email'])->redirect();
    }

    /**
     * Obtain the user information from LINE.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLineCallback()
    {
        try {
            $lineUser = Socialite::driver('line')->user();
            \Log::debug('LINE User Info: ', (array) $lineUser);
        } catch (\Exception $e) {
            \Log::error('LINE Login Error: ' . $e->getMessage());
            return redirect('/')->with('error', 'LINEでのログインに失敗しました。');
        }
        //dd($lineUser->getId());
        $user = User::updateOrCreate([
            'line_id' => $lineUser->getId(),
        ], [
            'name' => $lineUser->getName(),
            'email' => $lineUser->getEmail(),
            'password' => bcrypt(Str::random(16)), // パスワードは不要だが念のため設定
        ]);

        Auth::login($user, true);

        return redirect()->intended('dashboard');
    }
}