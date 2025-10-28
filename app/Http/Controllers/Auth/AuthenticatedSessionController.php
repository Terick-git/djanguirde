<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return inertia('Auth/Login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Vérifier le code d'accès pour admin/instructor
        $user = Auth::user();

        if ($user->requiresAccessCode()) {
            if ($request->access_code !== '3xDev') {
                Auth::logout();
                throw ValidationException::withMessages([
                    'access_code' => 'Code d\'accès "3xDev" requis pour ce type de compte.',
                ]);
            }
        }

        // Sauvegarder pour connexion automatique
        if ($request->remember) {
            $request->session()->put('auto_login_email', $request->email);
            $request->session()->put('auto_login_user_id', $user->id);
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
