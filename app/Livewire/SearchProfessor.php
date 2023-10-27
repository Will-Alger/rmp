<?php

namespace App\Livewire;

use App\Models\Professor;
use Livewire\Component;

class SearchProfessor extends Component
{
    public $search = "";

    public function render()
    {
        $professors = collect(); // Create an empty collection

        if (!empty($this->search)) {
            $professors = Professor::where(function($query) {
                $terms = explode(' ', $this->search);

                if (count($terms) > 1) {
                    $query->where('firstName', 'like', '%' . $terms[0] . '%')
                        ->where('lastName', 'like', '%' . $terms[1] . '%');
                } else {
                    $query->where('firstName', 'like', '%' . $this->search . '%')
                        ->orWhere('lastName', 'like', '%' . $this->search . '%');
                }
            })
                ->orderBy('numRatings', 'desc')
                ->limit(15)
                ->get();
        }

        return view('livewire.search-professor', [
            'professors' => $professors
        ]);


    }
}
