<?php

namespace App\Livewire;

use Livewire\Component;

class DepartmentToggle extends Component
{
    public $department;

    public function mount($department)
    {
        $this->department = $department;
    }

    public function updateShowInForms($value)
    {
        $this->department->show_in_forms = $value;
        $this->department->save();

        session()->flash('message_success', 'Done.');
    }

    public function render()
    {
        return view('livewire.department-toggle');
    }
}
