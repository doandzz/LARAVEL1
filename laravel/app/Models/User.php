<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $primarykey = 'id';
    public $timestamps = true;
    protected $fillable=[
        'tenant_id',
        'user_name',
        'password',
        'full_name',
        'phone',
        'email',
        'role',
        'status'
    ];
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function classes()
    {
        return $this->hasMany(Classes::class,'user_id');
    }

    public function confirmed_attendance()
    {
        return $this->hasMany(Confirmed_attendance::class,'user_id');
    }
    public function teacher()
    {
        return $this->hasOne(Teacher::class,'user_id');
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class,'tenant_id');
    }
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }
}
