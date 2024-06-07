<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class MyProfile extends Component
{
    #[Title('My Profile')]
    public function render()
    {
        return view('livewire.my-profile');
    }
}
