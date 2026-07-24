<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleRedirectController extends Controller
{
    public function redirect(Request $request)
    {
        $role = $request->query('role') ?: ($request->user()->role ?? 'user');


        if ($role === 'admin') {
            return redirect()->route('dashboard');
        }

        if ($role === 'mahasiswa') {
            return redirect('/tugas-akhir.index');
        }

        return redirect()->route('dashboard');
    }
}

