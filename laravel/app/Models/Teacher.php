<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Teacher extends Model
{
    protected $table='teachers';
    protected $primarykey= 'id';
    public $timestamps= true;
    protected $fillable=[
        'user_id',
        'identification_code',
        'teacher_code',
        'full_name',
        'gender',
        'birth_date',
        'address',
        'email',
        'phone',
        'face_url',
        'status'
        
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $this->table = $tenant->code . '_teachers';

    }
    public function classes()
    {
        return $this->hasMany(Classes::class,'teacher_id');
    }
    public function confirmed_attendance()
    {
        return $this->hasMany(Confirmed_attendance::class,'teacher_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
