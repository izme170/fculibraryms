<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryToggle extends Component
{
    public $category;

    public function mount(Category $category)
    {
        $this->category = $category;
    }

    public function updateShowInForms($value)
    {
        $this->category->show_in_forms = $value;
        $this->category->save();

        session()->flash('message_success', 'Done.');
    }

    public function render()
    {
        return view('livewire.category-toggle');
    }
}
