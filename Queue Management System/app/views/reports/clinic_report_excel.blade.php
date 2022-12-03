<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table>
    <thead>
    <tr style="background: #4c9bff;text-align: center;">
        <th>Clinic</th>
        <th>Doctor Name</th>
        <th>Scheduled T(H:M)</th>
        <th>Exceptions T(H:M)</th>
        <th>Utilization T(H:M)</th>
        <th>Estimated Visits</th>
        <th>Total Reservations</th>
        @if (app('production'))
            <th>No. Patients</th>
        @endif
        <th>No Show</th>
        <th>No Show Rate</th>
        @if (app('production'))
            <th>Utilization Rate(Pt/Hr)</th>
        @endif
    </tr>
    </thead>
    <tbody>
    @foreach($report as $key => $val)
        <?php $count = 0; ?>
        @foreach($val['physicians'] as $key2 => $val2)
            <tr>
{{--                @if($count == 0)--}}
                    <td style="background: #62d6ff;vertical-align: middle;">
                        {{$val['name']}}
                    </td>
                {{--@endif--}}
                <td style="background: #FFB5F5;">{{$val2['physicianData']['full_name']}}</td>
                <td>{{Functions::convertToHoursMins($val2['schedule_time'])}}</td>
                <td>
                    {{Functions::convertToHoursMins($val2['exception_time'])}}
                    ({{round(($val2['exception_time'] / $val2['schedule_time']) * 100, 1)}}%)
                </td>
                <td>
                    {{Functions::convertToHoursMins($val2['work_time'])}}
                    ({{round(($val2['work_time'] / $val2['schedule_time']) * 100, 1)}}%)
                </td>
                <td>{{$val2['estimate_visits']}}</td>
                <td>{{$val2['allVisits']}}</td>
                @if (app('production'))
                    <td>{{$val2['patientPaid']}}</td>
                @endif
                <td>{{$val2['noShow']}}</td>
                <td>
                    @if($val2['allVisits'])
                        {{round(($val2['noShow'] / $val2['allVisits']) * 100, 2)}}%
                    @else
                        0%
                    @endif
                </td>
                @if (app('production'))
                    <td @if($val2['PTSeenPerHour'] > 3) style="background: #4FFF29" @endif>{{$val2['PTSeenPerHour']}}</td>
                @endif
            </tr>
            <?php $count++; ?>
        @endforeach
    @endforeach
    </tbody>
</table>