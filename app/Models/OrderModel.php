<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    public $timestamps = true;
    public $remember_token = false;
    protected $guarded = [];

    public function kasir() {
        return $this->belongsTo('App\Models\KasirModel', 'id_kasir');
    }

    public function orderDetail() {
        return $this->hasMany('App\Models\OrderDetailModel');
    }
}
