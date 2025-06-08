@extends('layouts.admin', ['pageTitle' => 'Użytkownicy'])

@section('content')
<div class="container mt-4">
    <h2>Lista użytkowników</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Dodaj użytkownika</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa użytkownika</th>
                <th>Email</th>
                <th>Telefon</th>
                <th>Typ</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->type }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">Edytuj</a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Na pewno usunąć?')">Usuń</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
