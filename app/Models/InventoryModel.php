<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    protected $table = 'barang';
    public $timestamps = true;
    public $remember_token = false;
    protected $guarded = [];

    public function tenant() {
        return $this->belongsTo('App\Models\TenantModel', 'id_tenant');
    }
}
