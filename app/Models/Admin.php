<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use Notifiable, HasRoles, Concerns\DateFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRoleIdAttribute()
    {
        return $this->roles()->pluck('id');
    }

    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = \Hash::make($value);
        } else {
            unset($this->attributes['password']);
        }
    }

    public function setAvatarAttribute($value)
    {
        if ($value instanceof UploadedFile) {
            $this->attributes['avatar'] = $value->store(upload_path());
        } else {
            unset($this->attributes['avatar']);
        }
    }

    public static function guardName()
    {
        return 'admin';
    }

    public function getDisabledPermissions()
    {
        return AuthPermission::whereNotIn('id', $this->getAllPermissions()->pluck('id'))->get();
    }

    public function isDisabledUrl($url)
    {
        $request = app('request')->create($url);
        $route = app('router')->getRoutes()->match($request);
        return $this->getDisabledPermissions()->contains('name', $route->getName());
    }
}
