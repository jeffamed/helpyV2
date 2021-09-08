<p>{{ __('lang.ticket') }}: # {{ $data->ticket_id }} - {{ $data->title }}</p>
<p>{{ __('lang.current_department') }}: {{ $data->department->title }}</p>

<div class="form-group">
    <label for="Name">{{ __('lang.departments') }}:</label>
    <select class="form-control" name="department" id="assignedDepartment">
        <option disabled selected>{{ __('lang.select_department') }}</option>
        @foreach($departments as $department)
            <option value="{{ $department->id }}">{{ $department->title }}</option>
        @endforeach
    </select>
</div>