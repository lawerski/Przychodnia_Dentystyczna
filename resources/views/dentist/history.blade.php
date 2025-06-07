@extends('layouts.dentist', ['pageTitle' => 'Historia zabiegów'])

@section('content')
    <div class="container mt-5 mb-5">
        <h1 class="mt-4">Historia zabiegów</h1>
        <p>W tej sekcji możesz przeglądać historię swoich zabiegów.</p>

        @include('shared.dentist.procedures', ['procedures' => $procedures])
    </div>
@endsection
