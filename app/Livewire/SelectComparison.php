<?php

namespace App\Livewire;

use Livewire\Component;

class SelectComparison extends Component
{
    public $selected = 'Professor';

    public function updatedSelected($value)
    {
        error_log($value);
        $this->selected = $value;
    }
    public function render()
    {
        return view('livewire.select-comparison');
    }
}
