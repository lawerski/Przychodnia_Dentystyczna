@include('shared.html')

@include('shared.head', ['pageTitle' => 'Edytuj zabieg'])

@include('shared.dentist.navbar')

<form action="{{ route('service.edit', $service->id) }}" method="POST" class="container mt-4" style="max-width: 600px;">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="dentist_name" class="form-label">Dentysta:</label>
        <input type="text" name="dentist_name" id="dentist_name" class="form-control" value="{{ $dentist_name }}" disabled>
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
