<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Settings_time extends Model
{
    protected $table;
    protected $primarykey= 'id';
    public $timestamps= true;
    protected $fillable=[
        'day',
        'start_time',
        'end_time',
        'end_try_time'
    ];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $user = Auth::user();
        $tenant = Tenant::find($user->tenant_id);
        $this->table = $tenant->code . '_settings_time';

    }
}
