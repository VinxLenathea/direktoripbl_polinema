<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect to intended URL if available (e.g., laporan file)
        // Otherwise redirect based on user role
        $intendedUrl = redirect()->intended()->getTargetUrl();

        // Check if the intended URL is different from current URL
        // If it's a laporan URL, go directly to it
        if ($intendedUrl !== url('/') && str_contains($intendedUrl, '/laporan/')) {
            return redirect()->intended();
        }

        $userRole = Auth::user()->role;

        if ($userRole === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        }

        return redirect()->route('dashboard');
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('welcome')->with('success', 'Anda telah berhasil logout.');
    }
}
