<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;
    use LogsActivity;

    // protected $table = 'users';

    // protected static $logAttributes = [
    //     'username',
    //     'firstname',
    //     'lastname',
    //     'phone',
    //     'email',
    //     'gender',
    //     'active',
    // ];

    // protected static $ignoreChangedAttributes = [
    //     'password',
    //     'created_by',
    //     'updated_by',
    //     'deleted_by'
    // ];

    // protected static $recordEvents = [
    //     'create',
    //     'update'
    // ];

    // protected static $logOnlyDirty = true;

    // protected static $logName = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'firstname',
        'lastname',
        'phone',
        'email',
        'gender',
        'active',
        'delete',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    protected static $logFillable = true;

    protected $hidden = [
        'password',
        'delete',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [
            'username' => $this -> username,
            'lastname' => $this -> lastname,
            'role' => User::getRoleNames(),
            'permission' => User::getAllPermissions()->pluck('name')->toArray(),
        ];
    }

    
}