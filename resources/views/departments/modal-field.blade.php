<div class="form-group">
    <label for="title">{{ __('lang.title') }}:</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ $department->title }}">
</div>
<div class="form-group">
    <label for="description">{{ __('lang.description') }}:</label>
    <textarea type="text" class="form-control" id="description" name="description">{{ $department->description }}</textarea>
</div>