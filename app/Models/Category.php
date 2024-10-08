<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'name_ar',
        'department_id'
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function departmentStorages()
    {
        return $this->hasMany(DepartmentStorage::class);
    }
}
