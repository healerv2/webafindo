<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function index()
    {
        $profil = auth()->user();
        return view('profile.index', compact('profil'));
    }
}
