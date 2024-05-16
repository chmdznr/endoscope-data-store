<?php

namespace App\Http\Requests;

use App\Models\VisionData;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyVisionDataRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('vision_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:vision_datas,id',
        ];
    }
}
