<?php
// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogger;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Add honeypot check
        if ($request->filled('website')) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Invalid request.'], 422);
            }
            return back()->withErrors(['email' => 'Invalid request.']);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            if (!$user->is_admin) {
                Auth::logout();
                $request->session()->invalidate();
                
                if ($request->ajax()) {
                    return response()->json(['message' => 'Access denied. Admin privileges required.'], 403);
                }
                return back()->withErrors([
                    'email' => 'Access denied. Admin privileges required.',
                ]);
            }
            
            // Regenerate session ID to prevent session fixation
            $request->session()->regenerate();
            
            // Log successful login
            \Log::info('Admin login successful', ['user_id' => $user->uuid, 'ip' => $request->ip()]);
            ActivityLogger::logLogin($user);
            
            if ($request->ajax()) {
                return response()->json(['success' => true, 'redirect' => '/admin']);
            }
            return redirect()->intended('/admin');
        }

        // Log failed login attempt
        \Log::warning('Failed login attempt', ['email' => $request->email, 'ip' => $request->ip()]);

        if ($request->ajax()) {
            return response()->json(['message' => 'The provided credentials do not match our records.'], 422);
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log logout
        if ($user) {
            \Log::info('Admin logout', ['user_id' => $user->uuid, 'ip' => $request->ip()]);
            ActivityLogger::logLogout($user);
        }
        
        Auth::logout();
        
        // Clear all session data
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Clear remember me cookie
        $response = redirect('/admin/login')->with('status', 'You have been logged out successfully.');
        $response->withCookie(cookie()->forget('remember_web'));
        
        return $response;
    }
}
