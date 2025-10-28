<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return inertia('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:student,instructor,admin',
            'access_code' => 'nullable|string',
        ]);

        // Déterminer le rôle automatiquement basé sur l'email
        $role = $this->determineRole($request->email, $request->role);

        // Vérification du code d'accès pour admin/instructor
        if (in_array($role, ['admin', 'instructor'])) {
            if ($request->access_code !== '3xDev') {
                return back()->withErrors([
                    'access_code' => 'Code d\'accès "3xDev" requis pour créer un compte ' . $role,
                ]);
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    private function determineRole($email, $requestedRole)
    {
        // Si email contient admin@, forcer admin
        if (str_contains($email, 'admin@')) {
            return 'admin';
        }

        // Si email @djanguirde.com, forcer instructor
        if (str_contains($email, '@djanguirde.com')) {
            return 'instructor';
        }

        // Sinon utiliser le rôle demandé
        return $requestedRole;
    }
}
