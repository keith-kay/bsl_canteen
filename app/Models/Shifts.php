<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shifts extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural form of the model name
    protected $table = 'bsl_cmn_shifts';

    // Define the primary key if it's different from 'id'
    protected $primaryKey = 'bsl_cmn_shifts_id';

    // Specify the columns that can be mass assigned
    protected $fillable = [
        'bsl_cmn_shifts_name',
        'bsl_cmn_shifts_starttime',
        'bsl_cmn_shifts_endtime',
        'bsl_cmn_shifts_mealsnumber',
    ];

    // If the primary key is not an integer, you can specify its type
    // protected $keyType = 'string';

    // If the primary key is not auto-incrementing, set $incrementing to false
    // public $incrementing = false;

    // If the model should not use timestamps, set $timestamps to false
    // public $timestamps = false;

    // Define any relationships with other models if necessary
    public function users()
    {
        return $this->belongsToMany(CustomUser::class, 'user_has_shifts', 'shift_id', 'user_id');
    }
}
