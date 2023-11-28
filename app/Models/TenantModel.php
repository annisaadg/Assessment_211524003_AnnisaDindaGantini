<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantModel extends Model
{
    protected $table = 'tenant';
    public $timestamps = true;
    public $remember_token = false;
    protected $guarded = [];
}
