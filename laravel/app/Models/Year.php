<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $table='years';
    protected $primarykey= 'id';
    public $timestamps= true;
    protected $fillable=[
        'name'
    ];
    public function classes()
    {
        return $this->hasMany(Classes::class,'year_id');
    }
}
