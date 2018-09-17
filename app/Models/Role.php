<?php

namespace App\Models;

use Sentinel;
use Cartalyst\Sentinel\Roles\EloquentRole;

class Role extends EloquentRole
{
    /**
     * Получить всех пользователей принадлежащих к данной роли
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany("App\Models\User", "role_users");
    }

    /**
     * Метод для получения
     *
     * @return array
     */
    public static function getRoleUsers()
    {
        $roleUsers = array();
        $roles = Role::all();
        foreach ($roles as $role)
        {
            $users = $role->users()->get();
            $roleUsers[$role->slug] = $users;
        }
        return $roleUsers;
    }

    /**
     * @param array $data
     * @return array
     */
    static public function modifyPermissionsData(array $data)
    {
        $permissions = array();
        foreach($data as $key => $value)
        {
            $permissions[$key] = true;
        }
        return $permissions;
    }

    /**
     * @param array $routes
     * @return array
     */
    static public function modifyRoutesData(array $routes)
    {
        $permissions = array();
        foreach($routes as $name => $route)
        {
            $permissions[$name] = Util::strReplaceSlashToDot($route->uri);
        }
        return $permissions;
    }
}
