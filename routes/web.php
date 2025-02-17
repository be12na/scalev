<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsettingController;
use App\Models\User;
use App\Models\Websetting;
use App\Notifications\PesanWhatsApp;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    Cache::flush();
    return redirect()->route('dashboard');
});

Route::get('/test-wa', function(){

	$messageData = [
		'type' 		=> 'text',
		'content' 	=> 'Kirim pesan dengan OneSender',
    ];

	$user = User::find(1);

    $user->notify(new PesanWhatsApp($messageData));

    echo 'Pesan terkirim';
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth','role:superadmin']], function () { 

    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::patch('/user/{id}/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}/delete', [UserController::class, 'delete'])->name('user.delete');

    Route::get('/setting', [WebsettingController::class, 'index'])->name('setting.index');
    Route::post('/setting//update', [WebsettingController::class, 'store'])->name('setting.store');

});

require __DIR__.'/auth.php';
