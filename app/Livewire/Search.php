<?php

namespace App\Livewire;

use App\Models\Professor;
use Illuminate\Http\Request;
use Livewire\Component;

class Search extends Component
{
    public $__id;
    public $search = "";
    public $selectedProfessor = null;
    public $searchType = "professor";

    public function render()
    {
        $searchType = $this->searchType;
        $results = collect();

        if ($searchType == "professor")
            $results = $this->getProfessors();

        else if ($searchType == "school")
            $results = $this->getSchools();

        return view('livewire.search', [
            'searchType' => $this->searchType, 'results' => $results
        ]);
    }

    public function selectProfessor($professor)
    {
        $this->selectedProfessor = $professor;
        $this->dispatch('professorSelected', $professor);
    }

    public function getProfessors($count = 15)
    {
        if (empty($this->search))
            return collect();
        return Professor::where(function($query) {
            $terms = explode(' ', $this->search);

            if (count($terms) > 1) {
                $query->where('firstName', 'like', '%' . $terms[0] . '%')
                    ->where('lastName', 'like', '%' . $terms[1] . '%');
            } else {
                $query->where('firstName', 'like', '%' . $this->search . '%')
                    ->orWhere('lastName', 'like', '%' . $this->search . '%')
                    ->orWhere('legacyId', '=', '%' . $this->search . '%');
            }
        })
            ->orderBy('numRatings', 'desc')
            ->limit($count)
            ->get();
    }

    public function getSchools() {
        return collect();
    }

}
