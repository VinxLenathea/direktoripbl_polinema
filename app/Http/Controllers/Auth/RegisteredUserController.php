<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        return view('auth.register', [
            'role' => $request->query('role'),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:admin,mahasiswa'],
        ];

        if ($request->input('role') === 'mahasiswa') {
            $rules['nim'] = ['required', 'string', 'max:50', Rule::unique('mahasiswa', 'nim')->where(function ($query) {
                return $query->whereNotNull('user_id');
            })];
            $rules['jurusan'] = ['required', 'string', 'max:255'];
            $rules['prodi'] = ['required', 'string', 'max:255'];
        }

        $request->validate($rules);

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'role' => $request->string('role')->toString(),
        ]);

        if ($request->input('role') === 'mahasiswa') {
            Mahasiswa::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'nim' => $request->input('nim'),
                'jurusan' => $request->input('jurusan'),
                'prodi' => $request->input('prodi'),
            ]);
        }


        event(new Registered($user));

        Auth::login($user);

        // Flash success message to be displayed after redirect
        session()->flash('success', 'Akun berhasil dibuat. Selamat datang, ' . $user->name . '!');

        return redirect($user->role === 'mahasiswa'
            ? route('mahasiswa.dashboard', absolute: false)
            : route('dashboard', absolute: false)
        );
    }
}
