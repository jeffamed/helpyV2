@section('style')
    <!-- data table css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fixedHeader.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}" />
@stop

<div class="card-body table-responsive">
    <div class="mb-3">
        <div class="col-md-5 offset-7">
            <div id="reportrange" class="w-100 pointer pad-border">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
    </div>

    <table id="data_table" class="table table-bordered table-striped table-hover dataTable w-100">
        <thead>
        <tr>
            <th>{{ __('lang.sl_no') }}</th>
            <th>{{ __('lang.id') }}</th>
            <th>{{ __('lang.title') }}</th>
            <th>{{ __('lang.user') }}</th>
            <th>{{ __('lang.status') }}</th>
            <th>{{ __('lang.last_updated') }}</th>
            <th>{{ __('lang.actions') }}</th>
        </tr>
        </thead>
    </table>
</div>

<!-- Edit Product Modal -->
<div class="modal" id="TicketAssignedDepartmentModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg p-3 mb-5 bg-white rounded">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">{{ __('lang.change_or_assign') }}</h5>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>{{ __('lang.success') }} </strong>{{ __('lang.ticket_successfully_assigned') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="AssignedTicketModalBody">

                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitTicketAssignedForm">{{ __('lang.update') }}</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">{{ __('lang.close') }}</button>
            </div>
        </div>
    </div>
</div>

<!--page-loader-->
<div class="page-loader d-none">
    <div class="loader">
        <span class="dot dot_1"></span>
        <span class="dot dot_2"></span>
        <span class="dot dot_3"></span>
        <span class="dot dot_4"></span>
    </div>
</div>

@section('js')
    <!-- dataTables  -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <!-- bootstrap dataTables  -->
    <script src="{{ asset('assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.fixedHeader.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>

    <script src="{{ asset('assets/js/departmentTicketDataTable.js') }}"></script>
@endsection