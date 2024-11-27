<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuarios;

class ViewController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function register()
    {
        return view('createUser');
    }
    public function login()
    {
        return view('login');
    }
    public function home()
    {
        return view('home');
    }
    public function reloj(){
        return view('reloj');
    }
    public function userManagement()
    {
        if (Auth::user()->role != 1) {
            return redirect()->route('home');
        }

        $users = Usuarios::all();
        return view('user_management', compact('users')); // Ensure this view exists
    }

    public function music()
    {
        return view('music');
    }

    public function tamagotchi()
    {
        return view('tamagotchi');
    }
}
