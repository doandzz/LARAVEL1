<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Face_history extends Model
{
    protected $table;
    protected $primarykey= 'id';
    public$timestamps= true;
    protected $fillable=[
        'student_identification_code',
        'datetime',
        'tracking_image_url'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $this->table = $tenant->code . '_face_history';

    }
    public function student()
    {
        return $this->belongsTo(Student::class,'student_identification_code','student_identification_code');
    }
}
