<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FileType;

class StoreDepartmentStorageRequest extends FormRequest
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
            'title' => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'file_type' => 'required|exists:file_types,id',
            'file' => [
                'required',
                'file',
                $this->getMaxSizeRuleForFileType($this->input('file_type')),
                'mimes:' . $this->getAllowedMimeTypes($this->input('file_type')),
            ],
            'description' => 'required|string|max:150',
        ];
    }

    protected function getMaxSizeRuleForFileType($fileTypeId)
    {
        $fileType = FileType::findOrFail($fileTypeId);
        $maxSizes = [
            'Document' => 2048, // 2 MB
            'Powerpoint' => 5120, // 5 MB
            'Image' => 5120, // 5 MB
            'Video' => 20480, // 20 MB
            'PDF' => 5120, // 5 MB
        ];

        return function ($attribute, $value, $fail) use ($fileType, $maxSizes) {
            $maxSize = $maxSizes[$fileType->type] * 1024 * 1024; // Convert to bytes
            if ($value->getSize() > $maxSize) {
                $fail("The maximum file size for {$fileType->type} files is {$maxSizes[$fileType->type]} MB.");
            }
        };
    }

    protected function getAllowedMimeTypes($fileTypeId)
    {
        $fileType = FileType::findOrFail($fileTypeId);
        $allowedExtensions = $fileType->extensions;

        return  $allowedExtensions;
    }
 
}