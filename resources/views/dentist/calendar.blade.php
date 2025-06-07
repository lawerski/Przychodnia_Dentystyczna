@extends('layouts.dentist', ['pageTitle' => 'Kalendarz zabiegów'])

@section('content')
<div class="container mt-5 mb-5">
    <h1 class="mt-4">Kalendarz zabiegów</h1>
    <div class="mb-4">
        <label for="calendar-month" class="form-label">Wybierz miesiąc:</label>
        <input type="month" id="calendar-month" class="form-control" onchange="renderCalendar()" />
    </div>
    <div id="calendar-container"></div>

    <script>
        const procedures = @json($procedures);

        function getProceduresByDate(year, month) {
            const counts = {};
            procedures.forEach(proc => {
                const date = new Date(proc.date);
                if (date.getFullYear() === year && (date.getMonth() + 1) === month) {
                    const day = date.getDate();
                    counts[day] = (counts[day] || 0) + 1;
                }
            });
            return counts;
        }

        function renderCalendar() {
            const monthInput = document.getElementById('calendar-month').value;
            if (!monthInput) return;
            const [year, month] = monthInput.split('-').map(Number);
            const firstDay = new Date(year, month - 1, 1);
            const lastDay = new Date(year, month, 0).getDate();
            const startDay = firstDay.getDay() === 0 ? 7 : firstDay.getDay(); // Monday as first day

            const counts = getProceduresByDate(year, month);

            let html = '<table class="table table-bordered calendar-table">';
            html += '<thead><tr><th>Pon</th><th>Wt</th><th>Śr</th><th>Czw</th><th>Pt</th><th>Sob</th><th>Nd</th></tr></thead><tbody><tr>';

            let dayOfWeek = 1;
            for (let i = 1; i < startDay; i++) {
                html += '<td></td>';
                dayOfWeek++;
            }

            for (let day = 1; day <= lastDay; day++) {
                const count = counts[day] || 0;
                html += `<td${count ? ' class="bg-info text-white"' : ''}>${day}${count ? `<br><span class="badge bg-primary">${count}</span>` : ''}</td>`;
                if (dayOfWeek % 7 === 0 && day !== lastDay) {
                    html += '</tr><tr>';
                }
                dayOfWeek++;
            }

            while ((dayOfWeek - 1) % 7 !== 0) {
                html += '<td></td>';
                dayOfWeek++;
            }

            html += '</tr></tbody></table>';
            document.getElementById('calendar-container').innerHTML = html;
        }

        document.addEventListener('DOMContentLoaded', function() {
            showCurrentMonth();
            renderCalendar();
        });
    </script>
    <style>
        .calendar-table td {
            width: 40px;
            height: 60px;
            text-align: center;
            vertical-align: middle;
        }
    </style>
    <script>
        function showCurrentMonth() {
            const now = new Date();
            const month = now.toISOString().slice(0,7);
            document.getElementById('calendar-month').value = month;
        }
    </script>
</div>
@endsection
