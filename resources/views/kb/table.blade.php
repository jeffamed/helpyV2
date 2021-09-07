@section('style')
    <!-- data table css -->
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fixedHeader.bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/daterangepicker.css') }}" />
@stop

<div class="card-body table-responsive">
    <div class="row mb-2">
        <div class="col-md-4 mb-2">
            <select class="form-control" id="kbDepartment">
                <option value="all" selected>{{ __('lang.all_category') }}</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <select class="form-control" id="kbPinned">
                <option value="all" selected>{{ __('lang.all_pinned') }}</option>
                <option value="1">{{ __('lang.pinned') }}</option>
                <option value="0">{{ __('lang.unpinned') }}</option>
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <select class="form-control" id="kbStatus">
                <option value="all" selected>{{ __('lang.status_all') }}</option>
                <option value="1">{{ __('lang.published') }}</option>
                <option value="0">{{ __('lang.unpublished') }}</option>
            </select>
        </div>
    </div>

    <table id="data_table" class="table table-bordered table-striped table-hover dataTable w-100">
        <thead>
            <tr>
                <th>{{ __('lang.sl_no') }}</th>
                <th>{{ __('lang.title') }}</th>
                <th>{{ __('lang.content') }}</th>
                <th>{{ __('lang.category') }}</th>
                <th>{{ __('lang.views') }}</th>
                <th>{{ __('lang.pinned') }}</th>
                <th>{{ __('lang.created_by') }}</th>
                <th>{{ __('lang.status') }}</th>
                <th>{{ __('lang.actions') }}</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Delete Product Modal -->
<div class="modal" id="DeleteDataModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">{{ __('lang.delete') }}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>{{ __('lang.success') }} </strong>{{ __('lang.deleted_successfully') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h4>{{ __('lang.are_you_sure_you_want_to_delete') }}</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteForm">{{ __('lang.yes') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('lang.no') }}</button>
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

    <script src="{{ asset('assets/js/kbDataTable.js') }}"></script>
@endsection