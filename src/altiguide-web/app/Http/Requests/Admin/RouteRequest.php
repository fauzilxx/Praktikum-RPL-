<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RouteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'mountain_id'    => ['required', 'integer', 'exists:mountains,id'],
            'name'           => ['required', 'string', 'max:100'],
            'distance'       => ['required', 'numeric', 'min:0'],
            'estimated_time' => ['required', 'integer', 'min:1'], // In minutes
            'difficulty'     => ['required', 'in:easy,moderate,hard'],
            'image'          => [
                $isUpdate ? 'nullable' : 'nullable', 
                'image', 'mimes:jpeg,png,jpg,webp', 'max:2048' // Max 2MB Image
            ],
            'is_active'      => ['required', 'boolean'],
            'latitude'       => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'      => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}