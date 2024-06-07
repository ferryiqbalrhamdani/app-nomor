<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class LupaPassword extends Component
{
    #[Rule('required|exists:users,username')]
    public $username;

    public function lupaPassword()
    {
        $this->validate();

        if (Auth::user()->status == true) {
            User::where('username', $this->username)
                ->update(['is_password' => 1]);
            Alert::success('Pemberitahuan', 'Request anda sedang diproses oleh admin, mohon ditunggu ya. :)');
            return redirect('/login');
        } else {
            Alert::error('Pemberitahuan', 'Akun anda dibekukan, silahkan hubungi admin untuk info lebih lanjut.');
            return redirect('/lupa-password');
        }
    }

    #[Title('Lupa Password')]
    #[Layout('components.layouts.app-login')]
    public function render()
    {
        return view('livewire.auth.lupa-password');
    }
}
