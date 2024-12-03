<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Attendance extends Model
{
    protected $table;
    protected $primarykey= 'id';
    public$timestamps= true;
    protected $fillable=[
        'student_id',
        'user_id',
        'class_id',
        'time_in',
        'time_out',
        'tracking_image_url',
        'type',
        'status'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $this->table = $tenant->code . '_attendance';

    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function class()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
}
