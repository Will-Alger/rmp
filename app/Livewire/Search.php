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
        if ($this->searchType == "professor")
            $this->redirect(route('professor.show', ['professor' => $id]));
        else
            $this->redirect(route('school.show', ['school' => $id]));
    }

    public function updated($propertyName): void
    {
        if ($propertyName === 'searchType') {
            error_log('updatedSearchType was called.');
        }
    }


    public function getProfessors($count = 15)
    {
        if (empty($this->search))
            return collect();

        $terms = array_filter(explode(' ', $this->search));

        $searchTerms = implode(" ", array_map(function ($term) {
            return "+" . $term . "*";
        }, $terms));

        return Professor::select(['id', 'firstName', 'lastName', 'schoolName', 'numRatings'])
            ->whereRaw(
                "MATCH(firstName,lastName) AGAINST(? IN BOOLEAN MODE)",
                $searchTerms
            )
            ->orderBy('numRatings', 'desc')
            ->limit($count)
            ->get();
    }
    public function getSchools($count = 15)
    {
        if (empty($this->search))
            return collect();

        return School::where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('legacyId', '=', '%' . $this->search . '%');
        })
            ->orderBy('numRatings', 'desc')
            ->limit($count)
            ->get();
    }
}
