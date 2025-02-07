<?php

namespace App\Livewire;

use Livewire\Component;

class RemarkToggle extends Component
{
    public $remark;

    public function mount($remark)
    {
        $this->remark = $remark;
    }

    public function updateShowInForms($value)
    {
        $this->remark->show_in_forms = $value;
        $this->remark->save();

        session()->flash('message_success', 'Done.');
    }

    public function render()
    {
        return view('livewire.remark-toggle');
    }
}
