<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Dentist;
use Illuminate\Auth\Access\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class ServiceController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::when(request()->filled('dentist_id'), function ($q) {
            $q->where('dentist_id', request()->get('dentist_id'));
            })
            ->when(request()->filled('service_name'), function ($q) {
                $q->whereRaw('LOWER(service_name) LIKE ?', ['%' . strtolower(request()->get('service_name')) . '%']);
            })
            ->when(request()->filled('cost_max'), function ($q) {
            $q->where('cost', '<=', request()->get('cost_max'));
            })
            ->paginate(15);

        if (auth()->user()) {
            if (auth()->user()->hasRole('admin')) {
                return view('admin.service.index', [
                'services' => $services,
                'dentists' => Dentist::all(),
                'max_cost' => Service::max('cost'),
                ]);
            }

        }

        return view('service.index', [
            'services' => $services,
            'dentists' => Dentist::all(),
            'max_cost' => Service::max('cost'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $dentists = Dentist::all();
            return view('service.admin.create', [
            'dentists' => $dentists,
            ]);
        } else {
            $dentist = $user->dentist;
            $dentistName = $dentist->name ?? '';
            $dentistSurname = $dentist->surname ?? '';
            $dentistSpecialization = $dentist->specialization ?? '';
            $dentistText = $dentistName . ' ' . $dentistSurname . ' - ' . $dentistSpecialization;
            $dentistId = $dentist->id ?? null;
            return view('service.dentist.create', [
                'dentist_id' => $dentistId,
                'dentist_name' => $dentistText,
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateServiceRequest $request)
    {
        $this->authorize('create', [Service::class, $request]);

        $validatedData = $request->validated();

        // Create the service with the validated data
        $service = Service::create($validatedData);

        if (auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.service.index')
            ->with('success', 'Usługa została dodana pomyślnie.');
        } else {
            return redirect()->route('dentist.services')
            ->with('success', 'Usługa została dodana pomyślnie.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        $popularity = $service->reservations()
            ->where('date_time', '>=', now()->subWeek())
            ->where('status', 'wykonana')
            ->count();
        return view('service.show', [
            'popularity' => $popularity,
            'service' => $service,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $dentists = Dentist::all();
            return view('service.admin.edit', [
                'service' => $service,
                'dentists' => $dentists,
            ]);
        } else {
            $dentist = $service->dentist;
            $dentistName = $dentist->name ?? '';
            $dentistSurname = $dentist->surname ?? '';
            $dentistSpecialization = $dentist->specialization ?? '';
            $dentistText = $dentistName . ' ' . $dentistSurname . ' - ' . $dentistSpecialization;
            return view('service.dentist.edit', [
                'service' => $service,
                'dentist_name' => $dentistText,
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $this->authorize('update', $service);
        $service->update($request->validated());

        return redirect()->route('service.edit', $service)
            ->with('success', 'Usługa została zaktualizowana pomyślnie.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);
        $service->delete();
        return redirect()->back()
            ->with('success', 'Usługa została usunięta pomyślnie.');
    }

    /**
     * Display statistics for the services.
     */
    public function stats()
    {
        $monthAgo = Carbon::now()->subMonth();
        $stats = Service::withCount(['reservations' => function($q) use ($monthAgo) {
            $q->where('status', 'wykonana')->where('date_time', '>=', $monthAgo);
        }])->orderByDesc('reservations_count')->get();

        return view('service.stats', compact('stats'));
    }
}
