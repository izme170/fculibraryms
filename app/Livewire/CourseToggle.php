<?php

namespace App\Livewire;

use Livewire\Component;

class CourseToggle extends Component
{
    public $course;

    public function mount($course)
    {
        $this->course = $course;
    }

    public function updateShowInForms($value)
    {
        $this->course->show_in_forms = $value;
        $this->course->save();

        session()->flash('message_success', 'Done.');
    }

    public function render()
    {
        return view('livewire.course-toggle');
    }
}
