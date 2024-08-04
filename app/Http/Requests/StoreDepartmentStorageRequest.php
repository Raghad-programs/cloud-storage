<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\FileType;
use App\Http\Requests\MimeTypes;
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
                'mimetypes:' . implode(',', $this->getAllowedMimeTypes()),
            ],
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
    
    protected function getAllowedMimeTypes()
    {
        $fileType = FileType::find($this->input('file_type'));
        $allowedExtensions = explode(',', $fileType->extensions);
        $allowedMimeTypes = [];
    
        foreach ($allowedExtensions as $extension) {
            $allowedMimeTypes[] = $this->getMimeTypeByExtension(trim($extension));
        }
    
        return $allowedMimeTypes;
    }
    
    protected function getMimeTypeByExtension($extension)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $tempFile = tempnam(sys_get_temp_dir(), $extension);
        $mimeType = $finfo->file($tempFile);
        unlink($tempFile);
        return $mimeType;
    }
}
