<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentStorage extends Model
{
     use HasFactory;
    protected $fillable = [
        'title',
        'department_id',
        'user_id',
        'category_id',
        'file_type_id',
        'file_path',
        'file_name',
    ];

    protected $guarded;
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function categorys()
    {
        return $this->belongsTo(Category::class);
    }

    public function fileType()
    {
        return $this->belongsTo(FileType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
