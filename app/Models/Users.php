<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sentinel;

class Users extends Model
{
    /**
     * Метод для получения все ролей пользователей
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllRoles()
    {
        return Sentinel::getRoleRepository()->all();
    }

    /**
     * Метод для получения всех пользователйй
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllUsers()
    {
        return Sentinel::getUserRepository()->all();
    }

    /**
     * Метод для получения всех пользователей вместе с ролями
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getAllUsersWithRoles()
    {
        return Sentinel::getUserRepository()->with('roles')->get();
    }
}
