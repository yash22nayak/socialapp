<?php

use App\Http\Controllers\FriendRequestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('friend-requests', [FriendRequestController::class, 'index'])->name('friend-requests.index');
    Route::post('friend-requests/sent/{user}', [FriendRequestController::class, 'sent'])->name('friend-requests.sent');
    Route::delete('friend-requests/unfriend/{user}', [FriendRequestController::class, 'unfriend'])->name('friend-requests.unfriend');
    Route::post('friend-requests/accept/{friendRequest}', [FriendRequestController::class, 'accept'])->name('friend-requests.accept');
    Route::post('friend-requests/reject/{friendRequest}', [FriendRequestController::class, 'reject'])->name('friend-requests.reject');
    Route::get('search-users', [FriendRequestController::class, 'searchUsers'])->name('users.search');
});
