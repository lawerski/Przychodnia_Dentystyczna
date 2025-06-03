@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width:400px;">
    <h2>Reset hasła</h2>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Wygeneruj token resetu</button>
    </form>
    @if(session('status'))
        <div class="alert alert-success mt-3">{{ session('status') }}</div>
    @endif
</div>
@endsection
