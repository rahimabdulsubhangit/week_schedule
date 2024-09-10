<!DOCTYPE html>
<html>
<head>
    <title>Weekly Hours</title>
</head>
<body>
    <form method="POST" action="{{ route('weekly-hours.update') }}">
        @csrf
        <input type="hidden" name="week_start_date" value="{{ $startDate->format('Y-m-d') }}">

        <table border="1">
            <thead>
                <tr>
                    <th>Employee</th>
                    @for ($i = 0; $i < 7; $i++)
                        <th>{{ $startDate->copy()->addDays($i)->format('D j M') }}</th>
                    @endfor
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        @foreach(range(0, 6) as $i)
                            @php
                                $date = $startDate->copy()->addDays($i)->format('Y-m-d');
                                $hours = $employee->weeklyHours->firstWhere('date', $date);
                            @endphp
                            <td>
                                <input type="time" name="hours[{{ $employee->id }}][{{ $date }}]" value="{{ $hours->hours ?? '00:00' }}">
                            </td>
                        @endforeach
                        <td>
                            {{ $employee->weeklyHours->sum('hours') }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    @foreach($totalHours as $date => $total)
                        <td>{{ gmdate('H:i', $total * 3600) }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
        <button type="submit">Save</button>
    </form>
</body>
</html>