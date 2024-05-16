@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.visionData.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.vision-datas.update", [$visionData->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="trial_code">{{ trans('cruds.visionData.fields.trial_code') }}</label>
                <input class="form-control {{ $errors->has('trial_code') ? 'is-invalid' : '' }}" type="text" name="trial_code" id="trial_code" value="{{ old('trial_code', $visionData->trial_code) }}" required>
                @if($errors->has('trial_code'))
                    <span class="text-danger">{{ $errors->first('trial_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.trial_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.visionData.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $visionData->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gravidity">{{ trans('cruds.visionData.fields.gravidity') }}</label>
                <input class="form-control {{ $errors->has('gravidity') ? 'is-invalid' : '' }}" type="number" name="gravidity" id="gravidity" value="{{ old('gravidity', $visionData->gravidity) }}" step="1">
                @if($errors->has('gravidity'))
                    <span class="text-danger">{{ $errors->first('gravidity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.gravidity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="parity">{{ trans('cruds.visionData.fields.parity') }}</label>
                <input class="form-control {{ $errors->has('parity') ? 'is-invalid' : '' }}" type="number" name="parity" id="parity" value="{{ old('parity', $visionData->parity) }}" step="1">
                @if($errors->has('parity'))
                    <span class="text-danger">{{ $errors->first('parity') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.parity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="age">{{ trans('cruds.visionData.fields.age') }}</label>
                <input class="form-control {{ $errors->has('age') ? 'is-invalid' : '' }}" type="number" name="age" id="age" value="{{ old('age', $visionData->age) }}" step="1">
                @if($errors->has('age'))
                    <span class="text-danger">{{ $errors->first('age') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.age_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.visionData.fields.trial_type') }}</label>
                <select class="form-control {{ $errors->has('trial_type') ? 'is-invalid' : '' }}" name="trial_type" id="trial_type" required>
                    <option value disabled {{ old('trial_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\VisionData::TRIAL_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('trial_type', $visionData->trial_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('trial_type'))
                    <span class="text-danger">{{ $errors->first('trial_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.trial_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="time_taken">{{ trans('cruds.visionData.fields.time_taken') }}</label>
                <input class="form-control datetime {{ $errors->has('time_taken') ? 'is-invalid' : '' }}" type="text" name="time_taken" id="time_taken" value="{{ old('time_taken', $visionData->time_taken) }}" required>
                @if($errors->has('time_taken'))
                    <span class="text-danger">{{ $errors->first('time_taken') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.time_taken_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.visionData.fields.file_type') }}</label>
                <select class="form-control {{ $errors->has('file_type') ? 'is-invalid' : '' }}" name="file_type" id="file_type" required>
                    <option value disabled {{ old('file_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\VisionData::FILE_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('file_type', $visionData->file_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('file_type'))
                    <span class="text-danger">{{ $errors->first('file_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.file_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="file">{{ trans('cruds.visionData.fields.file') }}</label>
                <div class="needsclick dropzone {{ $errors->has('file') ? 'is-invalid' : '' }}" id="file-dropzone">
                </div>
                @if($errors->has('file'))
                    <span class="text-danger">{{ $errors->first('file') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notes">{{ trans('cruds.visionData.fields.notes') }}</label>
                <textarea class="form-control {{ $errors->has('notes') ? 'is-invalid' : '' }}" name="notes" id="notes">{{ old('notes', $visionData->notes) }}</textarea>
                @if($errors->has('notes'))
                    <span class="text-danger">{{ $errors->first('notes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.visionData.fields.notes_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    Dropzone.options.fileDropzone = {
    url: '{{ route('admin.vision-datas.storeMedia') }}',
    maxFilesize: 100, // MB
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100
    },
    success: function (file, response) {
      $('form').find('input[name="file"]').remove()
      $('form').append('<input type="hidden" name="file" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="file"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($visionData) && $visionData->file)
      var file = {!! json_encode($visionData->file) !!}
          this.options.addedfile.call(this, file)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="file" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection