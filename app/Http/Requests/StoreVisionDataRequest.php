<?php

namespace App\Http\Requests;

use App\Models\VisionData;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreVisionDataRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('vision_data_create');
    }

    public function rules()
    {
        return [
            'trial_code' => [
                'string',
                'required',
            ],
            'name' => [
                'string',
                'required',
            ],
            'gravidity' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'parity' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'age' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'trial_type' => [
                'required',
            ],
            'time_taken' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'file_type' => [
                'required',
            ],
            'file' => [
                'required',
            ],
        ];
    }
}
