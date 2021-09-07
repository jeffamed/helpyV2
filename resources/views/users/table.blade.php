@section('style')
    <!-- data table css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fixedHeader.bootstrap.min.css') }}">
@stop

<div class="card-body table-responsive">
    <table id="data_table" class="table table-bordered table-striped table-hover dataTable w-100">
        <thead>
        <tr>
            <th>{{ __('lang.sl_no') }}</th>
            <th>{{ __('lang.name') }}</th>
            <th>{{ __('lang.email') }}</th>
            <th>{{ __('lang.tickets') }}</th>
            <th>{{ __('lang.action') }}</th>
        </tr>
        </thead>
    </table>
</div>

@section('js')
    <!-- dataTables  -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <!-- bootstrap dataTables  -->
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.fixedHeader.min.js') }}"></script>

    <script src="{{ asset('assets/js/userDataTable.js') }}"></script>
@endsection