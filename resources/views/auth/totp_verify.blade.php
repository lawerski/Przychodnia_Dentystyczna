@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width:400px;">
    <h2>Weryfikacja TOTP</h2>
    <form method="POST" action="{{ route('totp.verify') }}">
        @csrf
        <label for="totp_code">Kod TOTP</label>
        <input type="text" name="totp_code" id="totp_code" class="form-control mb-3" required autofocus maxlength="6" pattern="[0-9]{6}">
        <button type="submit" class="btn btn-primary">Zweryfikuj</button>
    </form>
    @if($errors->has('totp_code'))
        <div class="alert alert-danger mt-3">{{ $errors->first('totp_code') }}</div>
    @endif
</div>
@endsection
