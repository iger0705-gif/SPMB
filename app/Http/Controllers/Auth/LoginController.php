<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            $selectedRole = $request->input('role');
            
            if ($user->role !== $selectedRole) {
                Auth::logout();
                return false;
            }
            
            return true;
        }
        
        return false;
    }
    
    protected function sendFailedLoginResponse(Request $request)
    {
        $credentials = $this->credentials($request);
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if ($user && $user->role !== $request->input('role')) {
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['role' => 'Role yang dipilih tidak sesuai dengan akun Anda.']);
        }
        
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'Email atau password salah.']);
    }
}
