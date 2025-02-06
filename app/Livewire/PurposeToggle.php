<?php

namespace App\Livewire;

use Livewire\Component;

class PurposeToggle extends Component
{
    public $purpose;

    public function mount($purpose)
    {
        $this->purpose = $purpose;
    }

    public function updateShowInForms($value)
    {
        $this->purpose->show_in_forms = $value;
        $this->purpose->save();

        session()->flash('message_success', 'Done.');
    }

    public function render()
    {
        return view('livewire.purpose-toggle');
    }
}
