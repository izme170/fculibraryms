<?php

namespace App\Livewire;

use Livewire\Component;

class ConditionToggle extends Component
{
    public $condition;

    public function mount($condition)
    {
        $this->condition = $condition;
    }

    public function updateShowInForms($value)
    {
        $this->condition->show_in_forms = $value;
        $this->condition->save();

        session()->flash('message_success', 'Done.');
    }

    public function render()
    {
        return view('livewire.condition-toggle');
    }
}
