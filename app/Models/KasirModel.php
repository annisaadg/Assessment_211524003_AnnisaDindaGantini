<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class KasirModel extends Authenticatable
{
    protected $table = 'kasir';

    use Notifiable;

    protected $guard = 'kasir';

    protected $fillable = [
        'username', 'password', 'fullname', 'email', 'is_active', 'is_deleted', 'code', 'phone_number'
    ];
}
