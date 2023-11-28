<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetailModel extends Model
{
    protected $table = 'order_detail';
    public $timestamps = true;
    public $remember_token = false;
    protected $guarded = [];

    public function barang() {
        return $this->belongsTo('App\Models\InventoryModel', 'id_barang');
    }
}
