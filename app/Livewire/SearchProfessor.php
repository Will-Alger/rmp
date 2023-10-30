<?php

namespace App\Livewire;

use App\Models\Professor;
use Illuminate\Http\Request;
use Livewire\Component;

class SearchProfessor extends Component
{
    public $search = "";
    public $selectionId = "";
    public $selectedProfessor = null;

    public function render()
    {
        $professors = collect();
        if (!empty($this->search)) {
            $professors = Professor::where(function($query) {
                $terms = explode(' ', $this->search);

                if (count($terms) > 1) {
                    $query->where('firstName', 'like', '%' . $terms[0] . '%')
                        ->where('lastName', 'like', '%' . $terms[1] . '%');
                } else {
                    $query->where('firstName', 'like', '%' . $this->search . '%')
                        ->orWhere('lastName', 'like', '%' . $this->search . '%')
                        ->orWhere('legacyId', 'like', '%' . $this->search . '%');
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

    public function selectProfessor($professor)
    {
//        error_log("selecting professor");
        $this->selectedProfessor = $professor;
        $this->dispatch('professorSelected', $professor);
    }

}
