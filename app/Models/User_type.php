<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_type extends Model
{
    protected $table = 'bsl_cmn_user_types';
    protected $primaryKey = 'bsl_cmn_user_types_id';
    protected $fillable = [

        'bsl_cmn_user_types_name',
        'bsl_cmn_user_types_status',
    ];
}
