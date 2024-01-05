<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles, Notifiable, HasFactory, Notifiable;
    protected $guard_name = 'admin';
    protected $fillable = ['name', 'email', 'role_id','status', 'password'];
    protected $hidden = ['password', 'remember_token'];
    public $with = ['role'];

    protected $casts = [

        'email_verified_at' => 'datetime'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
