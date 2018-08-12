<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Util;

class Roles extends Model
{

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
