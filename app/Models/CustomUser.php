<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;

class CustomUser extends Model implements Authenticatable
{
    use HasFactory, HasRoles, HasPermissions;

    protected $table = 'bsl_cmn_users';
    protected  $primaryKey = 'bsl_cmn_users_id';

    protected $fillable = [
        'bsl_cmn_users_firstname',
        'bsl_cmn_users_lastname',
        'bsl_cmn_users_employment_number',
        'bsl_cmn_users_pin',
        'bsl_cmn_users_type',
        'bsl_cmn_users_status',
        'email',
        'bsl_cmn_users_department',
        'password',
    ];

    // Implementing required methods for Authenticatable contract

    public function getAuthIdentifierName()
    {
        return 'bsl_cmn_users_id'; // Assuming 'id' is the primary key column name
    }

    public function getAuthPasswordName()
    {
        // Since you're not using a password for authentication, return null or an empty string
        return null;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getRememberTokenName()
    {
        return null; // If you don't have a remember token column, return null
    }

    public function setRememberToken($value)
    {
        // If you have a remember token column, set its value here
    }

    public function getRememberToken()
    {
        // If you have a remember token column, return its value here
    }
    // define a relationship between the models
    public function userType()
    {
        return $this->belongsTo(User_type::class, 'bsl_cmn_users_type');
    }
    public function isAdmin()
    {
        // Check if the user has the "admin" or "super-admin" role
        return $this->hasRole('admin') || $this->hasRole('super-admin');
    }
    public function shifts()
    {
        return $this->belongsToMany(Shifts::class, 'user_has_shifts', 'user_id', 'shift_id');
    }
}
