<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Student extends Model
{
    protected $table;
    protected $primarykey= 'id';
    public$timestamps= true;
    protected $fillable=[

        'class_id',
        'student_identification_code',
        'student_code',
        'full_name',
        'gender',
        'birth_date',
        'birthplace',
        'address',
        'guardian_full_name',
        'guardian_phone',
        'student_face_url',
        'status'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $this->table = $tenant->code . '_students';

    }
    public function classes()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }
    public function face_histories()
    {
        return $this->hasMany(Face_history::class,'student_identification_code','student_identification_code');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class,'student_id');
    }
}
