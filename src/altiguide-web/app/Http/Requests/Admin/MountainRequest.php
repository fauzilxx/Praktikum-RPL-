<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MountainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        // Validation rules adapt dynamically based on create or update
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name'        => ['required', 'string', 'max:100'],
            'location'    => ['required', 'string', 'max:100'],
            'altitude'    => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'latitude'    => ['required', 'numeric', 'between:-90,90'],
            'longitude'   => ['required', 'numeric', 'between:-180,180'],
            'status'      => ['required', 'in:open,closed,alert'],
            'image'       => [
                $isUpdate ? 'nullable' : 'nullable', 
                'image', 'mimes:jpeg,png,jpg,webp', 'max:2048' // Max 2MB Image
            ],
        ];
    }
}