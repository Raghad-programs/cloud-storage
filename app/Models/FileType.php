<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'extensions',
    ];

    public function departmentStorages()
    {
        return $this->hasMany(DepartmentStorage::class, 'file_type', 'id');
    }
}
