<?php

namespace App\Http\Controllers\MahasiswaAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MahasiswaAuth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('mahasiswa.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME_MAHASISWA);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('mahasiswa')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/mahasiswa/login');
    }
}
