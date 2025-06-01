@include('shared.html')

@include('shared.head', ['pageTitle' => 'Edytuj zabieg'])

@include('shared.admin.navbar')

@if(session('success'))
    <div class="alert alert-success container mt-4" style="max-width: 600px;" id="success-alert">
        {{ session('success') }}
        <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('success-alert').remove();"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger container mt-4" style="max-width: 600px;" id="error-alert">
        {{ session('error') }}
        <button type="button" class="btn-close float-end" aria-label="Close" onclick="document.getElementById('error-alert').remove();"></button>
    </div>
@endif


<form action="{{ route('service.update', $service->id) }}" method="POST" class="container mt-4" style="max-width: 600px;">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="dentist_id" class="form-label">Dentysta:</label>
        <select name="dentist_id" id="dentist_id" class="form-control" required>
            @foreach($dentists as $dentist)
                <option value="{{ $dentist->id }}" {{ old('dentist_id', $service->dentist_id) == $dentist->id ? 'selected' : '' }}>
                    {{ $dentist->name }} {{ $dentist->surname }} - ({{ $dentist->specialization }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="service_name" class="form-label">Nazwa zabiegu:</label>
        <input type="text" name="service_name" id="service_name" class="form-control" value="{{ old('service_name', $service->service_name) }}" required>
    </div>

    <div class="mb-3">
        <label for="cost" class="form-label">Koszt:</label>
        <input type="number" name="cost" id="cost" class="form-control" value="{{ old('cost', $service->cost) }}" step="0.01" required>
    </div>

    <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
</form>
