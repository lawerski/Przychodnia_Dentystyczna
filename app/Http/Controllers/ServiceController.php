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
            $q->where('service_name', 'like', '%' . request()->get('service_name') . '%');
            })
            ->when(request()->filled('cost_max'), function ($q) {
            $q->where('cost', '<=', request()->get('cost_max'));
            })
            ->paginate(15);
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

        return redirect()->route('service.edit', $service)
            ->with('success', 'Usługa została dodana pomyślnie.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
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
        return redirect()->route('dentist.services')
            ->with('success', 'Usługa została usunięta pomyślnie.');
    }
}
