<?php

namespace App\Livewire;

use Livewire\Component;

class MarketerToggle extends Component
{
    public $marketer;

    public function mount($marketer)
    {
        $this->marketer = $marketer;
    }

    public function updateShowInForms($value)
    {
        $this->marketer->show_in_forms = $value;
        $this->marketer->save();

        session()->flash('message_success', 'Done.');
    }

    public function render()
    {
        return view('livewire.marketer-toggle');
    }
}
