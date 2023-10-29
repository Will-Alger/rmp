<?php

namespace App\Livewire;
use App\Models\School;
use Livewire\Component;

class SearchSchool extends Component
{
    public $search = "";

    public function render()
    {
        $schools = collect();
        if (!empty($this->search)) {
            $schools = School::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('numRatings', 'desc')
                ->limit(15)
                ->get();
        }
        return view('livewire.search-school', [
            'schools' => $schools
        ]);
    }
}
