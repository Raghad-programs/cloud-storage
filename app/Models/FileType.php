<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'extensions',
    ];

    

    public function departmentStorages()
    {
        return $this->hasMany(DepartmentStorage::class, 'file_type', 'id');
    }
}