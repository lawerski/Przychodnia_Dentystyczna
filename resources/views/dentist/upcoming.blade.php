@extends('layouts.dentist', ['pageTitle' => 'Nadchodzące zabiegi'])

@section('content')
    <div class="container mt-5 mb-5">
        <h1 class="mt-4">Nadchodzące zabiegi</h1>
        <p>W tej sekcji możesz przeglądać nadchodzące zabiegi.</p>

        @include('shared.dentist.procedures', ['procedures' => $procedures])
    </div>
@endsection
