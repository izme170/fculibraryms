<?php

namespace App\Livewire;

use App\Models\Adviser;
use Livewire\Component;

class AdviserToggle extends Component
{
    public $adviser;

    public function mount(Adviser $adviser)
    {
        $this->adviser = $adviser;
    }

    // This method will be triggered when the checkbox is toggled
    public function updateShowInForms($value)
    {
        $this->adviser->show_in_forms = $value;
        $this->adviser->save();

        session()->flash('message_success', 'Done.');
    }

    public function render()
    {
        return view('livewire.adviser-toggle');
    }
}
