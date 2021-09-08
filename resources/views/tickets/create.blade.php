@extends('layouts.master')

@section('title', __('lang.submit_a_ticket'))
@section('content')

<div class="container my-5">
    @include('includes.flash')
    <form id="customerform" role="form" method="POST" action="{{ route('new-ticket-store.store') }}"  enctype="multipart/form-data">
        {!! csrf_field() !!}
        <div class="card person-card">
            <div class="card-body">
                <div class="text-center">                
                    <i class="fa fa-question-circle-o fa-3x"></i>
                    <h2 class="card-title">{{ __('lang.whats_happening_write_us') }}</h2>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 {{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="department">Title</label>
                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="{{ __('lang.enter_problem_title') }}" required>
                        @if ($errors->has('title'))
                            <span class="text-danger">
                                {{ $errors->first('title') }}
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="department" class="col-form-label">{{ __('lang.department') }}</label>
                        <select id="department" type="" class="form-control {{ $errors->has('department') ? ' has-error' : '' }}" name="department">
                            <option value="">{{ __('lang.select_department') }}</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                            @endforeach
                        </select>

                            @if ($errors->has('department'))
                                <span class="text-danger">
                                    {{ $errors->first('department') }}
                                </span>
                            @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="priority">{{ __('lang.priority') }}</label>
                        <select id="priority" type="" class="form-control {{ $errors->has('priority') ? ' has-error' : '' }}" name="priority">
                            <option value="">{{ __('lang.select_priority') }}</option>
                            <option value="low">{{ __('lang.low') }}</option>
                            <option value="medium">{{ __('lang.medium') }}</option>
                            <option value="high">{{ __('lang.high') }}</option>
                        </select>

                            @if ($errors->has('priority'))
                                <span class="text-danger">
                                    {{ $errors->first('priority') }}
                                </span>
                            @endif
                    </div>

                    <div class="form-group col-md-12">
                        <label for="message">{{ __('lang.message') }}</label>
                        <textarea rows="6" id="message" class="form-control my-editor {{ $errors->has('message') ? ' has-error' : '' }}" name="message">{{ old('message') }}</textarea>

                        @if ($errors->has('message'))
                            <span class="text-danger">
                                {{ $errors->first('message') }}
                            </span>
                        @endif
                    </div>
                    <!-- custom field -->
                    @foreach($fields as $field)
                    <div class="form-group col-md-12">
                        <label for="field{{$field->id}}">{{ $field->name }}</label>
                        @if($field->type == 'text')
                        <input type="hidden" name="text_field_id[]" value="{{ $field->id }}">
                        <input id="field{{$field->id}}" type="{{ $field->type }}" max="{{ $field->field_length }}" class="form-control" name="text_value[]" value="" placeholder="{{ $field->placeholder }}" {{ $field->required == 1? 'required': '' }}>
                        

                        @elseif($field->type == 'select')
                            <input type="hidden" name="option_field_id[]" value="{{ $field->id }}">
                            <select class="form-control" id="field{{$field->id}}" name="option_value[]">
                                @foreach($field->options as $option)
                                <option value="{{ $option->value }}">{{ $option->value }}</option>
                                @endforeach
                            </select>
                        @elseif($field->type == 'radio')
                            <br>
                            <input type="hidden" name="radio_field_id[]" value="{{ $field->id }}">
                            <div class="form-check-inline">
                                @foreach($field->options as $option)
                                <label class="customradio mr-2">
                                    <span class="radiotextsty">{{ $option->value }}</span>
                                        <input type="radio" name="radio_value[]" value="{{ $option->value }}">
                                    <span class="checkmark"></span>
                                </label>
                                @endforeach
                            </div>
                        @elseif($field->type == 'checkbox')
                            <input type="hidden" name="checkbox_field_id[]" value="{{ $field->id }}">
                            <div class="checkbox">
                                <label><input type="checkbox" name="checkbox_value[]" value="{{ $field->name }}" class="mr-2">{{ $field->name }}</label>
                            </div>
                        @elseif($field->type == 'file')
                            <img src="" id="image_preview" style="max-height:150px" />
                            <input type="hidden" name="file_field_id[]" value="{{ $field->id }}">
                            <input type="file" name="file_value[]" class="form-control-file" id="imgFile" accept="image/*">
                        @endif
                    </div>
                    @endforeach
                </div>
                <div class="mt-1">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">{{ __('lang.submit_ticket') }}</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
    <!-- tinymce editor js -->
    <script src="{{asset('tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('tinymce/script.js')}}"></script>
    <script>
        $("#imgFile").change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#image_preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0])
        })
    </script>
@stop