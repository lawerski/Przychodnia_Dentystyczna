@extends('layouts.main', ['pageTitle' => 'Statystyki popularności zabiegów'])

@section('content')
<div class="container mt-4">
    <h2>Popularność zabiegów w ostatnim miesiącu</h2>
    <canvas id="statsChart" height="100"></canvas>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Zabieg</th>
                <th>Liczba wykonanych zabiegów</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stats as $service)
            <tr>
                <td>{{ $service->service_name }}</td>
                <td>{{ $service->reservations_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statsChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($stats->pluck('service_name')) !!},
            datasets: [{
                label: 'Liczba wykonanych zabiegów',
                data: {!! json_encode($stats->pluck('reservations_count')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection