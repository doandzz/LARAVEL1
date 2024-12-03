<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Confirmed_attendance extends Model
{
    protected $table;
    protected $primarykey= 'id';
    public$timestamps= true;
    protected $fillable=[
        'user_id',
        'teacher_id',
        'class_id',
        'confirmation_time'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $this->table = $tenant->code . '_confirmed_attendance';

    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function class()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }
}
