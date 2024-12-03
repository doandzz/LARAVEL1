<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Classes extends Model
{
    use HasFactory;

    protected $table;
    protected $primarykey= 'id';
    public $timestamps= true;
    protected $fillable=[
        'name',
        'user_id',
        'year_id',
        'teacher_id',
        'status'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $this->table = $tenant->code . '_classes';

    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }
    public function students()
    {
        return $this->hasMany(Student::class,'class_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }
    public function confirmed_attendance()
    {
        return $this->hasMany(Confirmed_attendance::class,'class_id');
    }

    public function scopeFromTable($query, $tableName) 
    {
        $query->from($tableName);
    }
    
}
