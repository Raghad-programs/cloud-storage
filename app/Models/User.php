<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\FileUploaded;
use App\Notifications\FileDeleted;



class User extends Authenticatable
{
    use HasFactory, Notifiable;

    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'Depatrment_id',
        'role_id',
        'storage_size'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'Depatrment_id', 'id');
    }

    public function departmentStorages()
    {
        return $this->hasMany(DepartmentStorage::class);
    }

    public function isAdmin()
{
    return $this->role->id === 1;
}

public function notifyDepartmentAdmins($message)
{
    $admins = self::where('Depatrment_id', $this->Depatrment_id)->get();
    foreach ($admins as $admin) {
        if ($admin->isAdmin()) {
            $admin->notify(new FileUploaded($message));
        }
    }
}

public function notifyDepartmentAdminsOnDeletion($message)
{
    $admins = self::where('Depatrment_id', $this->Depatrment_id)->get();
    foreach ($admins as $admin) {
        if ($admin->isAdmin()) {
            $admin->notify(new FileDeleted($message));
        }
    }
}

    
}

