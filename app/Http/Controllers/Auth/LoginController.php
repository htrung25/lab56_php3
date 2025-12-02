<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username_or_email' => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($request->username_or_email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($field, $request->username_or_email)
                    ->where('active', 1)
                    ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Nếu là admin → chuyển sang cổng admin
            if ($user->role === 'admin') {
                return redirect('http://127.0.0.1:8001/admin/dashboard');
            }

            return redirect()->route('movies.index');
        }

        return back()->withErrors([
            'username_or_email' => 'Thông tin đăng nhập không chính xác hoặc tài khoản bị khóa.',
        ])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}