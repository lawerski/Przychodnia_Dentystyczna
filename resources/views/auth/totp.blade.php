@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width:400px;">
    <h2>Aktywacja TOTP</h2>
    <p>Zeskanuj kod QR w aplikacji Google Authenticator lub wpisz ręcznie sekret:</p>
    <div>
        <img src="{{ $qrCodeUri }}" alt="Kod QR">
    </div>
    <p><strong>Sekret:</strong> {{ $secret }}</p>
</div>
@endsection
