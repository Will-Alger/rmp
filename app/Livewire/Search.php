<?php

namespace App\Livewire;

use App\Models\Professor;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Search extends Component
{
    public $id;
    public $search = "";
    public $searchType;
    public $selection = null;

    public function render()
    {
        $searchType = $this->searchType;
        $results = collect();

        $searchType == "professor"
            ? $results = $this->getProfessors()
            : $results = $this->getSchools();

        return view('livewire.search', [
            'searchType' => $this->searchType, 'results' => $results
        ]);
    }

    public function handleSelection($id): void
    {
        $professor = Professor::find($id);
        error_log($id . ' was selected');
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'searchType') {
            error_log('updatedSearchType was called.');
        }
    }

    public function getProfessors($count = 15)
    {
        if (empty($this->search))
            return collect();
        return Professor::where(function ($query) {
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

    public function getSchools()
    {
        if (empty($this->search))
            return collect();

        return School::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('legacyId', '=', '%' . $this->search . '%');
        })
            ->orderBy('numRatings', 'desc')
            ->limit(15)
            ->get();
    }
}
