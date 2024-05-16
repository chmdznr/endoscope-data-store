@extends('layouts.admin')
@section('content')
@can('vision_data_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.vision-datas.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.visionData.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.visionData.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-VisionData">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.trial_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.gravidity') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.parity') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.age') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.trial_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.time_taken') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.file_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.file') }}
                        </th>
                        <th>
                            {{ trans('cruds.visionData.fields.notes') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\VisionData::TRIAL_TYPE_SELECT as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\VisionData::FILE_TYPE_SELECT as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($visionDatas as $key => $visionData)
                        <tr data-entry-id="{{ $visionData->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $visionData->id ?? '' }}
                            </td>
                            <td>
                                {{ $visionData->trial_code ?? '' }}
                            </td>
                            <td>
                                {{ $visionData->name ?? '' }}
                            </td>
                            <td>
                                {{ $visionData->gravidity ?? '' }}
                            </td>
                            <td>
                                {{ $visionData->parity ?? '' }}
                            </td>
                            <td>
                                {{ $visionData->age ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\VisionData::TRIAL_TYPE_SELECT[$visionData->trial_type] ?? '' }}
                            </td>
                            <td>
                                {{ $visionData->time_taken ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\VisionData::FILE_TYPE_SELECT[$visionData->file_type] ?? '' }}
                            </td>
                            <td>
                                @if($visionData->file)
                                    <a href="{{ $visionData->file->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endif
                            </td>
                            <td>
                                {{ $visionData->notes ?? '' }}
                            </td>
                            <td>
                                @can('vision_data_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.vision-datas.show', $visionData->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('vision_data_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.vision-datas.edit', $visionData->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('vision_data_delete')
                                    <form action="{{ route('admin.vision-datas.destroy', $visionData->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('vision_data_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.vision-datas.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-VisionData:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection