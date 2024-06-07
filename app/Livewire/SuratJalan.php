<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class SuratJalan extends Component
{
    #[Title('Surat Jalan')]
    public function render()
    {
        return view('livewire.surat-jalan');
    }
}
