<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class UbahPassword extends Component
{
    #[Rule('required|min:3')]
    public $password;
    #[Rule('same:password')]
    public $confirmPassword;

    public $showpassword = false;

    public function openPas()
    {
        $this->showpassword = !$this->showpassword;
    }

    public function ubah()
    {
        $this->validate();

        User::where('id', Auth::user()->id)
            ->update([
                'password' => Hash::make($this->password),
            ]);

        Alert::toast('Selamat Datang ' . Auth::user()->first_name, 'success');
        return redirect('/dashboard');
        // return redirect(Auth::user()->role_id == 1 ? '/dashboard' : '/hari-ini');
    }

    #[Title('Ubah Password')]
    #[Layout('components.layouts.app-login')]
    public function render()
    {
        return view('livewire.auth.ubah-password');
    }
}
