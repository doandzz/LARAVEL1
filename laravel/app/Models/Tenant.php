<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $table='tenant';
    protected $primarykey= 'id';
    public $timestamps= true;
    protected $fillable=[
        'code',
        'name',
        'status',
    ];
    public function users()
    {
        return $this->hasMany(User::class,'tenant_id');
    }

}
