<?php

namespace App\Providers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleHelper
{
    public const admin= 'Admin';
    public const resolver= 'Engineer';
    public const general= 'Tech';
    public const dep_admin= 'Admin';
    const user= 'User';
    public static function isAdmin(): bool
    {
        return self::haveRole(self::admin);
    }
    public static function isEngineer(): bool
    {
        return self::haveRole(self::resolver);
    }

    public static function isDepAdmin(): bool
    {
        return self::haveRole(self::dep_admin) || self::haveRole(self::admin);
    }

    public static function haveRole($role)
    {
        $roles =explode(",",Auth::user()->roles);
        return in_array($role,$roles);
    }
}

