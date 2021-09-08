@section('style')
    <!-- data table css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fixedHeader.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}" />
@stop

<div class="card-body table-responsive">
    <div class="row mb-2">
        <div class="col-md-3 mb-2">
            <select class="form-control" id="ticketDepartment">
                <option value="all" selected>{{ __('lang.all_department') }}</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <select class="form-control" id="ticketPriority">
                <option value="all" selected>{{ __('lang.all_priority') }}</option>
                <option value="low">{{ __('lang.low') }}</option>
                <option value="medium">{{ __('lang.medium') }}</option>
                <option value="high">{{ __('lang.high') }}</option>
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <select class="form-control" id="ticketOptType">
                <option value="all" selected>{{ __('lang.all_issue_type') }}</option>
                @foreach($options as $option) 
                    <option value="{{ $option->value }}"> {{ $option->value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 mb-2">
            <div id="reportrange" class="w-100 pointer pad-border">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-md-3 mb-2">
            <select class="form-control" id="ticketTypes2">
                <option value="all" selected>{{ __('lang.all_type') }}</option>
                @foreach($optType as $option) 
                    <option value="{{ $option->value }}"> {{ $option->value }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table id="data_table" class="table table-bordered table-striped table-hover dataTable w-100">
        <thead>
        <tr>
            <th>{{ __('lang.department') }}</th>
            <th>{{ __('lang.id') }}</th>
            <th>{{ __('lang.title') }}</th>
            <th>{{ __('lang.priority') }}</th>
            <th>{{ __('lang.type') }} / {{ __('lang.issue_type') }}</th>
            <th>{{ __('lang.user') }}</th>
            <th>{{ __('lang.status') }}</th>
            <th>{{ __('lang.jira') }}</th>
            <th>{{ __('lang.submitted_date') }}</th>
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

<!-- Add JIRA Modal -->
<div class="modal" id="getJiraModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg p-3 mb-5 bg-white rounded">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Add URL JIRA</h5>
                <button type="button" class="close modelClose btnclosejira" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" id="alertjiraerror" role="alert" style="display: none;">
                    <strong>Error:</strong>The JIRA field is required.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="form-gruop col-md-12">
                    <input type="hidden" name="txtidticket" id="txtidticket" value="">
                    <label for="jira">JIRA:</label>
                    <input type="text" name="jira" id="jira" class="form-control" value="{{ old('jira') }}" placeholder="Add the id, example: TASK-XX">
                </div>

                <div class="alert alert-success alert-dismissible fade show" id="alertjirasuccess" role="alert" style="display: none;">
                    <strong>Success: </strong>JIRA assigned successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnUpdateJira"> Add </button>
                <button type="button" class="btn btn-danger modelClose btnclosejira" data-dismiss="modal">{{ __('lang.close') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- Button Close Modal -->
<div class="modal" id="btnCloseModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg p-3 mb-5 bg-white rounded">
            <!-- Modal Header -->
            <div class="modal-header">
                <h6 class="modal-title">Close Ticket</h6>
                <button type="button" class="close closeModalTicket" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p>Are you sure, you want to close this ticket <span id="txtNumTicket"></span>?</p>
                <input type="hidden" name="txtTicketClose" id="txtTicketClose" value="">
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btnSureClose">{{ __('lang.sure') }}</button>
                <button type="button" class="btn btn-outline-danger closeModalTicket" data-dismiss="modal">{{ __('lang.cancel') }}</button>
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

    <script src="{{ asset('assets/js/dtMain.js') }}"></script>
@endsection