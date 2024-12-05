<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Auth;

class UserManagementComponent extends Component
{
    public $users;

    public function mount()
    {
        $this->users = Usuarios::all();
    }

    public function updateUserRole($id, $role)
    {
        if (Auth::user()->role != 1) {
            return redirect()->route('home');
        }

        $user = Usuarios::find($id);
        if ($user) {
            $user->role = $role;
            $user->save();
            $this->users = Usuarios::all();
        }
    }

    public function deleteUser($id)
    {
        if (Auth::user()->role != 1) {
            return redirect()->route('home');
        }

        $user = Usuarios::find($id);
        if ($user) {
            $user->delete();
            $this->users = Usuarios::all();
        }
    }

    public function render()
    {
        return view('livewire.user-management-component');
    }
}