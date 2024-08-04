<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FileType;

class UpdateDepartmentStorageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'category_id' => 'required|exists:categories,id',
            'file_type' => 'required|exists:file_types,id',
            $this->container->make(FileType::class)->find($this->input('file_type'))->extensions,
            'description' => 'required|string|max:150',
        ];
    }
}