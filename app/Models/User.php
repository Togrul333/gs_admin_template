<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\OrderType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles,HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'number',
        'full_name',
        'password',
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
    protected $with = ['photos','activeOrders'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function photos()
    {
        return $this->morphMany(Media::class, 'manipulationable');
    }
    protected function mainPhoto(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->photos->first()   ? $this->photos->first()->document :  asset('frontend/assets/images/user.svg')
        );
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
    public function activeOrders()
    {
        return $this->hasMany(Order::class, 'user_id')
            ->where('order_status_id',OrderType::APPROVED)
            ->where('expiration_date','>=',now());
    }
}
