<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RouteWaypointRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name'                   => ['required', 'string', 'max:150'],
            'altitude'               => ['nullable', 'integer', 'min:0'],
            'order_index'            => ['required', 'integer', 'min:0'],
            'distance_from_prev'     => ['nullable', 'numeric', 'min:0'],
            'estimated_time_minutes' => ['nullable', 'integer', 'min:0'],
            'description'            => ['nullable', 'string'],
            'image'                  => [
                $isUpdate ? 'nullable' : 'nullable', 
                'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'
            ],
            'has_water_source'       => ['required', 'boolean'],
        ];
    }
}