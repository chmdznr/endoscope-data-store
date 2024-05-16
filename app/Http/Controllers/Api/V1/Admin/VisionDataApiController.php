<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreVisionDataRequest;
use App\Http\Requests\UpdateVisionDataRequest;
use App\Http\Resources\Admin\VisionDataResource;
use App\Models\VisionData;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisionDataApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('vision_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VisionDataResource(VisionData::all());
    }

    public function store(StoreVisionDataRequest $request)
    {
        $visionData = VisionData::create($request->all());

        if ($request->input('file', false)) {
            $visionData->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        return (new VisionDataResource($visionData))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(VisionData $visionData)
    {
        abort_if(Gate::denies('vision_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new VisionDataResource($visionData);
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

        return (new VisionDataResource($visionData))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(VisionData $visionData)
    {
        abort_if(Gate::denies('vision_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $visionData->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
