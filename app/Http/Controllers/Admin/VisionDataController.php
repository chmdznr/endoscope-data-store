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

class VisionDataController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('vision_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visionDatas = VisionData::with(['media'])->get();

        return view('admin.visionDatas.index', compact('visionDatas'));
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
