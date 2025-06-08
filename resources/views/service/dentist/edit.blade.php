@include('shared.html')

@include('shared.head', ['pageTitle' => 'Edytuj zabieg'])

@include('shared.dentist.navbar')

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
        <input type="text" class="form-control" value="{{ $dentist_name }}" disabled>
        <input type="hidden" name="dentist_id" id="dentist_id" value="{{ $service->dentist_id }}">
        @error('dentist_id')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="service_name" class="form-label">Nazwa zabiegu:</label>
        <input type="text" name="service_name" id="service_name" class="form-control @error('service_name') is-invalid @enderror" value="{{ old('service_name', $service->service_name) }}" required>
        @error('service_name')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label for="cost" class="form-label">Koszt:</label>
        <input type="number" name="cost" id="cost" class="form-control @error('cost') is-invalid @enderror" value="{{ old('cost', $service->cost) }}" step="0.01" required>
        @error('cost')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <div class="d-flex justify-content-between">
        <a href="{{ route('dentist.services') }}" class="btn btn-secondary">Powrót</a>
        <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
    </div>
</form>
