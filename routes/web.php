<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|

client id = 154297821054-h61c86d6jkf66p4k4es126ce6mhr4psm.apps.googleusercontent.com
secret = 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

*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('auth/google',[GoogleController::class,'redirectToGoogle']);
Route::get('auth/google/callback',[GoogleController::class,'handleGoogleCallback']);


Route::get('auth/facebook',[GoogleController::class,'FacebookRedirect']);
Route::get('auth/facebook/callback',[GoogleController::class,'FbResponse']);
