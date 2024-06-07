<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;

class Login extends Component
{
    #[Rule('required|exists:users,username')]
    public $username;
    #[Rule('required|min:3')]
    public $password;

    public $showpassword = false;

    public function loginAction()
    {
        $credentials = $this->validate();

        if (Auth::attempt($credentials)) {
            if (Auth::user()->status == 1) {
                // Check if the password is 'user123'
                if (Hash::check('user123', Auth::user()->password)) {
                    return redirect('/ubah-password');
                } else {
                    Alert::toast('Selamat Datang ' . Auth::user()->first_name, 'success');
                    return redirect('/dashboard');
                    // return redirect(Auth::user()->role_id == 1 ? '/dashboard' : '/nomor-surat/hari-ini');
                }
            }
            Alert::error('Gagal login', 'Akun user dibekukan, silahkan hubungi admin untuk info lebih lanjut.');
            return redirect('login');
        }

        Alert::error('Gagal login', 'Password yang anda masukan tidak sesuai.');
        return redirect('login');
    }

    public function openPas()
    {
        $this->showpassword = !$this->showpassword;
    }
    #[Layout('components.layouts.app-login')]
    public function render()
    {
        return view('livewire.auth.login');
    }
}
