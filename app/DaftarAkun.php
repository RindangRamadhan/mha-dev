<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaftarAkun extends Model
{
    protected $fillable = [
        'id_user', 'nama_akun'
    ];

    public function user() {
        return $this->hasOne('App\User','id','id_user');
    }
}
