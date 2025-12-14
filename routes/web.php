<?php

use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Socialite;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/google-auth/redirect',function() {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-auth/callback',function() {
    $userGoogle = Socialite::driver('google')->user();
    $user = User::updateOrCreate(
        [
            'google_id' => $userGoogle->id,
        ],
        [
            'name'=> $userGoogle->name,
            'email' => $userGoogle->email,
        ]);

        //auth()->login($user);
        Auth::login($user);
        return redirect('/dashboard');
    //(return Socialite::driver('google')->redirect();
})->name('google.callback');

/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
 */
/* Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); */

require __DIR__.'/auth.php';
