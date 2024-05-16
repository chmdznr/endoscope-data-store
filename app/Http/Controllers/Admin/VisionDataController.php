<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyVisionDataRequest;
use App\Http\Requests\StoreVisionDataRequest;
use App\Http\Requests\UpdateVisionDataRequest;
use App\Models\VisionData;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class VisionDataController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('vision_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = VisionData::query()->select(sprintf('%s.*', (new VisionData)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'vision_data_show';
                $editGate      = 'vision_data_edit';
                $deleteGate    = 'vision_data_delete';
                $crudRoutePart = 'vision-datas';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('trial_code', function ($row) {
                return $row->trial_code ? $row->trial_code : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('gravidity', function ($row) {
                return $row->gravidity ? $row->gravidity : '';
            });
            $table->editColumn('parity', function ($row) {
                return $row->parity ? $row->parity : '';
            });
            $table->editColumn('age', function ($row) {
                return $row->age ? $row->age : '';
            });
            $table->editColumn('trial_type', function ($row) {
                return $row->trial_type ? VisionData::TRIAL_TYPE_SELECT[$row->trial_type] : '';
            });

            $table->editColumn('file_type', function ($row) {
                return $row->file_type ? VisionData::FILE_TYPE_SELECT[$row->file_type] : '';
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . $row->file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('notes', function ($row) {
                return $row->notes ? $row->notes : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'file']);

            return $table->make(true);
        }

        return view('admin.visionDatas.index');
    }

    public function create()
    {
        abort_if(Gate::denies('vision_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.visionDatas.create');
    }

    public function store(StoreVisionDataRequest $request)
    {
        $visionData = VisionData::create($request->all());

        if ($request->input('file', false)) {
            $visionData->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $visionData->id]);
        }

        return redirect()->route('admin.vision-datas.index');
    }

    public function edit(VisionData $visionData)
    {
        abort_if(Gate::denies('vision_data_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.visionDatas.edit', compact('visionData'));
    }

    public function update(UpdateVisionDataRequest $request, VisionData $visionData)
    {
        $visionData->update($request->all());

        if ($request->input('file', false)) {
            if (! $visionData->file || $request->input('file') !== $visionData->file->file_name) {
                if ($visionData->file) {
                    $visionData->file->delete();
                }
                $visionData->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($visionData->file) {
            $visionData->file->delete();
        }

        return redirect()->route('admin.vision-datas.index');
    }

    public function show(VisionData $visionData)
    {
        abort_if(Gate::denies('vision_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.visionDatas.show', compact('visionData'));
    }

    public function destroy(VisionData $visionData)
    {
        abort_if(Gate::denies('vision_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visionData->delete();

        return back();
    }

    public function massDestroy(MassDestroyVisionDataRequest $request)
    {
        $visionDatas = VisionData::find(request('ids'));

        foreach ($visionDatas as $visionData) {
            $visionData->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('vision_data_create') && Gate::denies('vision_data_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new VisionData();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
