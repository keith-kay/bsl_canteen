<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealType extends Model
{
    use HasFactory;

    protected $table = 'bsl_cmn_mealtypes';
    protected  $primaryKey = 'bsl_cmn_mealtypes_id';

    protected $fillable = [
        'bsl_cmn_mealtypes_mealname',
        'bsl_cmn_mealtypes_mealname_site',
        'bsl_cmn_mealtypes_numberofmeals',
        'bsl_cmn_mealtypes_starthour',
        'bsl_cmn_mealtypes_duration',
        'bsl_cmn_mealtypes_status'
    ];

    public function site()
    {
        return $this->belongsTo(Sites::class, 'bsl_cmn_mealtypes_site', 'bsl_cmn_sites_id');
    }
}
