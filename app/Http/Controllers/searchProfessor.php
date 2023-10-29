<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class searchProfessor extends Controller
{
    public function search(Request $request)
    {
        $searchTerms = explode(' ', $request->get('search'));
        if (count($searchTerms) < 2) {
            return [];
        }
        $query = Professor::query();
        $query->where(function ($query) use ($searchTerms) {
            $query->where('firstName', 'like', '%' . $searchTerms[0] . '%')
                ->Where('lastName', 'like', '%' . $searchTerms[1] . '%');
            });
        $professors = $query->limit(50)->get();

        $professors = $professors->map(function ($professor) {
            return [
                'id' => $professor->id,
                'name' => $professor->firstName . ' ' . $professor->lastName,
            ];
        });
        return $professors->toArray();
    }







//        return Professor::where(function($query) use ($search) {
//            $terms = explode(' ', $search);
//            if (count($terms) > 1) {
//                $query->where('firstName', 'like', '%' . $terms[0] . '%')
//                    ->where('lastName', 'like', '%' . $terms[1] . '%');
//            } else {
//                $query->where('firstName', 'like', '%' . $search . '%')
//                    ->orWhere('lastName', 'like', '%' . $search . '%');
//            }
//        })
//            ->limit(5)
//            ->get()
//            ->map(function($professor) {
//                return ['id' => $professor->id, 'name' => $professor->firstName];
//            })
//            ->toArray();
}
