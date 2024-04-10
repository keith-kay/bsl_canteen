<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    use HasFactory;

    protected $table = 'cnt_mgn_db_sites';

    protected $fillable = [
        'cnt_mgn_db_sites.name',
        'cnt_mgn_db_sites.status',
    ];
}
