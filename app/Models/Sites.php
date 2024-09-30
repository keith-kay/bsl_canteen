<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Printers;

class Sites extends Model
{
    use HasFactory;

    protected $table = 'bsl_cmn_sites';
    protected $primaryKey = 'bsl_cmn_sites_id';

    protected $fillable = [
        'bsl_cmn_sites_name',
        'bsl_cmn_sites_status',
        'bsl_cmn_sites_device_ip'
    ];

    public function ip()
    {
        return $this->belongsTo(IPs::class, 'bsl_cmn_sites_ip', 'bsl_cmn_IPs_id');
    }

    public function getSiteByIP($ip)
    {
        return self::where('bsl_cmn_sites_device_ip', $ip)->first();
    }
    public function printer()
    {
        return $this->hasMany(Printers::class, 'site_id');
    }
}
