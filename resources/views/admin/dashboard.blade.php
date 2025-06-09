@extends('layouts.admin', ['pageTitle' => 'Panel Admina'])

@section('content')
<div class="container mt-4">
    <h2>Panel Admin</h2>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-primary mb-3">Przejdź do rezerwacji</a>
    <p>Pusty panel Admin</p>
</div>
@endsection
