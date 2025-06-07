<?php

namespace App\Http\Controllers;

use App\Models\Dentist;
use Illuminate\Http\Request;

class PublicDentistController extends Controller
{
    public function index(Request $request)
    {
        $query = Dentist::query();

        // Search functionality
        if ($request->has('search') && !empty($request->get('search'))) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('surname', 'like', "%{$search}%")
                  ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        // Only apply specialization filter if a specific one is selected
        if ($request->filled('specialization')) {
            $query->where('specialization', $request->specialization);
        }

        // Sorting
        $sortField = $request->get('sort', 'surname');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        // Get unique specializations for filter dropdown
        $specializations = Dentist::select('specialization')
            ->distinct()
            ->whereNotNull('specialization')
            ->orderBy('specialization')
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