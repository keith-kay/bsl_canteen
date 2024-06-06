<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sites;

class Printers extends Model
{
    use HasFactory;
    protected $table = 'printers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'site_id',
        'address',
        'port',
        'status'
    ];

    public function site()
    {
        return $this->belongsTo(Sites::class, 'site_id', 'bsl_cmn_sites_id');
    }
}
