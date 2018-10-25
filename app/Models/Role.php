<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'name', 'permissions',
    ];

    /**
     * Получить всех пользователей принадлежащих к данной роли
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany("App\Models\User");
    }

    /**
     * Метод для получения списка ролей в виде ключей и
     * список пользователей для каждой роли в виде значения
     *
     * @return array
     */
    public static function getRoleUsers()
    {
        $roleUsers = array();
        $roles = Role::all();
        foreach ($roles as $role)
        {
            $users = $role->users;
            $roleUsers[$role->slug] = $users;
        }
        return $roleUsers;
    }

    /**
     * Метод преобразует данные в нужный формат для записи в базу
     *
     * FIXME можно переделать, так как этот метод применялся для старой систмы пользователей Sentinent
     *
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
     * Метод преобразования роутов в нужный формат для вывода
     * их на странице создания/редактирования ролей
     *
     * @param array $routes
     * @return array
     */
    static public function modifyRoutesData(array $data)
    {
        $routes = array();
        foreach($data as $name => $route)
        {
            $routes[$name] = Util::strReplaceSlashToDot($route->uri);
        }
        return $routes;
    }
}
