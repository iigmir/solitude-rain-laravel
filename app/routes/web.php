<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect("/login");
});

Route::get("/login", function () {
    return view("login");
});

Route::get("/third-login/github", function () {
    return Socialite::driver('github')->redirect();
});

Route::get("/third-login/process", function () {
    $user = Socialite::driver('github')->user();
    $user = User::updateOrCreate([
        'github_id' => $githubUser->id,
    ], [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
        'github_token' => $githubUser->token,
        'github_refresh_token' => $githubUser->refreshToken,
    ]);
    Auth::login($user);
    return redirect("/third-login/success");
});

Route::get("/third-login/success", function () {
    $user = Socialite::driver('github')->user();
    return view("third-login-success");
});
