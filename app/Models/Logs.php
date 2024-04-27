<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $table = 'bsl_cmn_logs';

    protected $fillable = [
        'bsl_cmn_logs.person',
        'bsl_cmn_logs_mealtype',
        'bsl_cmn_logs.time',
    ];
    public function user()
    {
        return $this->belongsTo(CustomUser::class, 'bsl_cmn_logs_person', 'bsl_cmn_users_id');
    }

    public function mealType()
    {
        return $this->belongsTo(MealType::class, 'bsl_cmn_logs_mealtype', 'bsl_cmn_mealtypes_id');
    }
}
