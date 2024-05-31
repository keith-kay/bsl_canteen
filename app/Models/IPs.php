<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPs extends Model
{
    use HasFactory;

    protected $table = 'bsl_cmn_IPs';
    protected $primaryKey = 'bsl_cmn_IPs_id';

    protected $fillable = [
        'bsl_cmn_IPs_name',
        'bsl_cmn_IPs_address',
    ];
}
