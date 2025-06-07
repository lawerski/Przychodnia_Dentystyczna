<?php

namespace App\Http\Controllers;

use App\Models\Dentist;
use Illuminate\Http\Request;

class PublicDentistController extends Controller
{
    public function index(Request $request)
    {
        $query = Dentist::query();

        // Filtering
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        if ($request->has('specialization')) {
            $query->where('specialization', $request->get('specialization'));
        }

        // Sorting
        $sortField = $request->get('sort', 'surname');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Get unique specializations for filter
        $specializations = Dentist::select('specialization')
            ->distinct()
            ->pluck('specialization');

        // Pagination
        $dentists = $query->paginate(9)->withQueryString();

        return view('public.dentists.index', compact('dentists', 'specializations'));
    }

    public function show(Dentist $dentist)
    {
        return view('public.dentists.show', compact('dentist'));
    }
}