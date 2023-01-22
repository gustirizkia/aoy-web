<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListKota extends Model
{
    use HasFactory;

    protected $table = "subdistricts_ro";
    protected $guarded = [];
}
