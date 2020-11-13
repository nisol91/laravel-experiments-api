<?php

namespace App;

use App\Traits\HasPermissions;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // questa funzione fa un OVERRIDE del metodo illuminate (nei vendor) sendEmailVerificationNotification(). serve per mandare la
    // email di conferma indirizzo email custom
    /**
     * sendEmailVerificationNotification
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    // stessa cosa per mandare email custom per reset password
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }





    /*
    ROLES AND PERMISSIONS vedi controller Api\GetUserRole
    */

    // vedi anche il controller Api\GetUserRole
    public function isUserAdmin()
    {
        if ($this->roles()->where(
            'slug',
            'developer'
        )->exists() || $this->roles()->where(
            'slug',
            'admin'
        )->exists()) {
            return true;
        } else {
            return false;
        }
    }

    // non utilizzato per ora
    public function hasRole(...$roles)
    {
        // $user->hasRole('admin', 'developer');
        return $this->roles()->whereIn('slug', $roles)->count();
    }


    // relations

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    // non utilizzato per ora
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'users_categories');
    }

    public function userSettings()
    {
        return $this->hasOne(UserSettings::class);
    }
}
