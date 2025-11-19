<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;

// Test route to verify admin user
Route::get('/test-admin', function () {
    $user = User::where('email', 'baraaalrifaee732@gmail.com')->first();
    
    if ($user) {
        return response()->json([
            'user_found' => true,
            'name' => $user->name,
            'email' => $user->email,
            'is_admin' => $user->is_admin,
            'message' => $user->is_admin ? 'User is admin' : 'User is not admin'
        ]);
    }
    
    return response()->json([
        'user_found' => false,
        'message' => 'User not found'
    ]);
});