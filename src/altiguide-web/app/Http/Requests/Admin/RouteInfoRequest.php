<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RouteInfoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'basecamp_address'       => ['nullable', 'string'],
            'basecamp_altitude'      => ['nullable', 'integer', 'min:0'],
            'simaksi_price'          => ['nullable', 'numeric', 'min:0'],
            'ojek_price'             => ['nullable', 'numeric', 'min:0'],
            'ojek_description'       => ['nullable', 'string'],
            'facilities_description' => ['nullable', 'string'],
            'logistics_description'  => ['nullable', 'string'],
        ];
    }
}