<?php
namespace App\Livewire;

use Livewire\Component;

class IndexComponent extends Component
{
    public function render()
    {
        return view('livewire.index-component');
    }
    public function register(Request $request)
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
            $user->role = 2;
            $user->save();
            Auth::login($user);
            return view('home');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) { // Duplicate entry error code
                return back()->withErrors(['email' => 'El correo electrónico ya está registrado.'])->with('alert', 'El correo electrónico ya está registrado.');
            }
            throw $e;
        }
    }
}
