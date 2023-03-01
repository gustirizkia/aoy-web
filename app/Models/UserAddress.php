<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $table = 'users_address';

    public function provinsi(){
        return $this->belongsTo('App\Models\ListProvinsi', 'province_id', 'province_id');
    }

    public function kota(){
        return $this->belongsTo('App\Models\ListKota', 'city_id', 'city_id');
    }

    public function kecamatan(){
        return $this->belongsTo('App\Models\ListKecamatan', 'subdistrict_id', 'subdistrict_id');
    }
}
