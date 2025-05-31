@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width:400px;">
    <h2>Logowanie</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Hasło</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <button type="submit" class="btn btn-primary">Zaloguj</button>
    </form>
</div>
@endsection
