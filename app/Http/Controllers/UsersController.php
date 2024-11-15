<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Ensure you have the User model imported

class UsersController extends Controller
{
    public function postUsers(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ],
        [
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'El correo electrónico debe ser una dirección de correo electrónico válida',
            'email.unique' => 'El correo electrónico ya está registrado',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ]);

        try {
            $user = new Usuarios();
            $user->name = $request['name'];
            $user->email = $request->input('email');
            $user->password = Hash::make($request['password']);
            $user->save();
            return view('login');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) { // Duplicate entry error code
                return back()->withErrors(['email' => 'El correo electrónico ya está registrado.'])->with('alert', 'El correo electrónico ya está registrado.');
            }
            throw $e;
        }
    }

    public function enterUsers(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ],
        [
            'email.required' => 'El correo electrónico es requerido',
            'email.email' => 'El correo electrónico debe ser una dirección de correo electrónico válida',
            'password.required' => 'La contraseña es requerida',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('user_name', Auth::user()->name);

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Credenciales incorrectas',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login'); // Update this line to redirect to the correct login route
    }

    public function updateUserRole(Request $request, $id)
    {
        if (Auth::user()->role != 1) {
            return redirect()->route('home');
        }

        $request->validate([
            'role' => 'required|integer|in:1,2',
        ]);

        $user = Usuarios::find($id);
        if (!$user) {
            return redirect()->route('user_management')->withErrors(['user' => 'Usuario no encontrado']);
        }

        $user->role = $request['role'];
        $user->save();

        return redirect()->route('user_management')->with('success', 'Rol actualizado correctamente');
    }

    public function deleteUser($id)
    {
        if (Auth::user()->role != 1) {
            return redirect()->route('home');
        }

        $user = Usuarios::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('user_management')->with('success', 'Usuario eliminado correctamente');
        }

        return redirect()->route('user_management')->withErrors(['user' => 'Usuario no encontrado']);
    }
}
