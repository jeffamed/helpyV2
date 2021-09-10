<table>
    <thead>
        <tr>
            <th><b>Department</b></th>
            <th><b>ID</b></th>
            <th><b>Title</b></th>
            <th><b>Priority</b></th>
            <th><b>Type / Issue Type</b></th>
            <th><b>User</b></th>
            <th><b>Status</b></th>
            <th><b>JIRA</b></th>
            <th><b>Open Date</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td style="width: 25px;">{{ $ticket->departments }}</td>
                <td style="width: 25px;">{{ $ticket->ticket_id }}</td>
                <td style="width: 25px;">{{ $ticket->title }}</td>
                <td style="width: 25px;">{{ $ticket->priority }}</td>
                <td style="width: 25px;">{{ $ticket->valueType }} / {{ $ticket->value }}</td>
                <td style="width: 25px;">{{ $ticket->users }}</td>
                <td style="width: 25px;">{{ $ticket->status }}</td>
                <td style="width: 25px;">{{ $ticket->jira }}</td>
                <td style="width: 25px;">{{ $ticket->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>