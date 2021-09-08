@extends('dashboard.master')
@section('style')

@stop
@section('title', $ticket->title)

@section('main-section')
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h4>
                <div class="mb-2">#{{ $department->title }} - {{ __('lang.department_ticket') }}</div>
                <hr>
                #{{ $ticket->ticket_id }} - {{ $ticket->title }}
                <input type="hidden" id="txtTickedId" value="{{ $ticket->ticket_id }}">
            </h4>
          </div>
        </div>
      </div>
    </section>
    @include('includes.flash')
    <section>
      <div class="container-fluid">
        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-red">{{ $ticket->created_at->toDayDateTimeString() }}</span>
              </div>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <div>
                <i class="fa fa-envelope bg-blue"></i>
                <div class="timeline-item">
                  <span class="time float-right"><i class="fa fa-clock-o"></i> {{ $ticket->created_at->diffForHumans() }}</span>
                  <h3 class="timeline-header"><a href="javascript:void(0);">{{ $ticket->user->name }}</a> {{ __('lang.sent_you_ticket_for_support') }}</h3>
                  <div class="timeline-body">
                    {!! clean($ticket->message) !!}
                    <hr>
                    <div class="">
                      @foreach($ticket->ticketCustomField as $customField)
                        @if($customField->fields->type == 'file')
                          <div class=""><strong>{{ $customField->fields->name }}</strong>: <img src="{{ asset(symImagePath().$customField->value) }}" class="img-thumbnail"></img></div>
                        @else
                          <p><strong>{{ $customField->fields->name }}</strong>: {{ $customField->value }}</p>
                        @endif
                      @endforeach
                    </div>
                  </div>
                  <div class="timeline-footer">
                    @if ($ticket->status === 'Open')
                        Status: <span class="badge bg-primary text-white">{{ $ticket->status }}</span>
                    @else
                        Status: <span class="badge bg-warning text-white">{{ $ticket->status }}</span>
                    @endif
                  </div>
                </div>
              </div>
              <!-- END timeline item -->
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-green">{{ __('lang.reply') }}</span>
              </div>
                @forelse ($comments as $comment)
                      @if($comment->public != 0)
                      <div>
                        <i class="fa fa-comments bg-yellow"></i>
                        <div class="timeline-item">
                          <span class="time"><i class="fas fa-clock"></i> {{ $comment->created_at->toDayDateTimeString() }}</span>
                          <h3 class="timeline-header"><a href="javascript:void(0);">{{ $comment->user->name }}</a> {{ __('lang.commented_on_your_ticket') }}</h3>
                            <div class="timeline-body">
                                {!! clean($comment->comment) !!}
                            </div>
                        </div>
                      </div>
                      @elseif(Auth::user()->is_admin || (Auth::user()->role != null && Auth::user()->role->title === 'Admin'))
                      <div>
                        <i class="fa fa-comments bg-yellow"></i>
                        <div class="timeline-item" style="background-color: rgba(243, 243, 202, 0.98)">
                          <span class="time"><i class="fas fa-clock"></i> {{ $comment->created_at->toDayDateTimeString() }}</span>
                            <h3 class="timeline-header"><a href="javascript:void(0);">{{ $comment->user->name }}</a> {{ __('lang.commented_on_your_ticket') }}</h3>
                            <div class="timeline-body">
                              {!! clean($comment->comment) !!}
                          </div>
                        </div>
                      </div>
                      @endif
                @empty
                <div>
                    <div class="timeline-item">
                        <div class="timeline-body">
                            {{ __('lang.no_reply_found') }}
                        </div>
                    </div>
                </div>
                @endforelse
              <!-- /.timeline-label -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.timeline -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-pencil"></i> {{ __('lang.reply_ticket') }}</h3>
                    </div>
                    @if($ticket->status == 'Open')
                    <div class="card-body">
                        <form role="form" class="m-0" method="POST" action="{{ route('comment.postComment') }}">
                            {!! csrf_field() !!}
                            <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                            <textarea class="textarea my-editor" name="comment" placeholder="{{ __('lang.place_of_answer') }}">{{ clean(old('comment')) }}</textarea>
                            <div class="form-group">
                                <label for="title">{{ __('lang.status') }}</label><br>
                                <div class="form-check-inline">
                                    <label class="customradio"><span class="radiotextsty">{{ __('lang.open') }}</span>
                                      <input type="radio" checked="checked" name="status" value="Open" required>
                                      <span class="checkmark"></span>
                                    </label>        
                                    <label class="customradio"><span class="radiotextsty">{{ __("lang.closed") }}</span>
                                      <input type="radio" name="status" value="Closed" required>
                                      <span class="checkmark"></span>
                                    </label>
                                </div>
                                @if(Auth::user()->is_admin || (Auth::user()->role != null && Auth::user()->role->title === 'Admin'))
                                  <div class="form-check-inline">
                                    <label class="customradio"><span class="radiotextsty">{{ __("lang.private") }}</span>
                                        <input type="checkbox" name="private" value="private">
                                        <span class="checkmark"></span>
                                      </label>
                                  </div>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                              <input id="id_jira" type="text" name="jira" value="{{$ticket->jira ?? old('ticket_solved')}}" placeholder="Add the id, example: TASK-XX" class="form-control">
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ __('lang.submit_reply') }}</button>
                              </div>
                            </form>
                            <button title="Close" type="submit" id="btnClose" class="btn btn-outline-danger pull-right"><i class="fa fa-times" aria-hidden="true"></i> {{ __("lang.close") }}</button>
                    </div>
                    @else
                    <div class="card-body">
                        {{ __("lang.you_can't_reply_because_ticket_closed") }}
                    </div>
                    @endif
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
                      <p>Are you sure, you want to close this ticket?</p>
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
    </section>
@endsection

@section('js')
  <script src="{{asset('tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('tinymce/script.js')}}"></script>
  <script>
    $(function () {
        let value = 0;
        let bool = false;
        $("#id_jira").click(function(){
            value =  $('#id_jira').val();
            $(this).val("");
        });

        $("#id_jira").blur(function(){
          if (bool === false){
            $(this).val(value);
          }
          if ($('#id_jira').val().length === 0){
              $(this).val(value);
          }
        });
        
        $("#id_jira").keyup(function(){
            bool = true;
        });

        // open modal btn Close
        $('body').on('click', '#btnClose', function(e) {
            e.preventDefault();
            $('#btnCloseModal').show();
        });

        $('.closeModalTicket').on('click', function(){
            $('#btnCloseModal').hide();
        });

        $('#btnSureClose').click(function (){
            let id = $("#txtTickedId").val();
            let url = window.appUrl+"/close_ticket/"+id
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $.post(url, function(value) {
              $('#btnCloseModal').hide();
                location.reload();
            });
        })

    })
  </script>
@endsection