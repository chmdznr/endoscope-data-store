@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.visionData.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vision-datas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.id') }}
                        </th>
                        <td>
                            {{ $visionData->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.trial_code') }}
                        </th>
                        <td>
                            {{ $visionData->trial_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.name') }}
                        </th>
                        <td>
                            {{ $visionData->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.gravidity') }}
                        </th>
                        <td>
                            {{ $visionData->gravidity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.parity') }}
                        </th>
                        <td>
                            {{ $visionData->parity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.age') }}
                        </th>
                        <td>
                            {{ $visionData->age }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.trial_type') }}
                        </th>
                        <td>
                            {{ App\Models\VisionData::TRIAL_TYPE_SELECT[$visionData->trial_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.time_taken') }}
                        </th>
                        <td>
                            {{ $visionData->time_taken }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.file_type') }}
                        </th>
                        <td>
                            {{ App\Models\VisionData::FILE_TYPE_SELECT[$visionData->file_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.file') }}
                        </th>
                        <td>
                            @if($visionData->file)
                                <a href="{{ $visionData->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.visionData.fields.notes') }}
                        </th>
                        <td>
                            {{ $visionData->notes }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.vision-datas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection