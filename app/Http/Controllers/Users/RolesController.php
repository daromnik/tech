<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\Roles;
use Route;
use Sentinel;

class RolesController extends Controller
{
    /**
     * Страница списка всех ролей пользователей
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $roles = Users::getAllRoles();
        return view("users.roles.list", ["roles" => $roles]);
    }

    /**
     * Страница формы добавления новой роли пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $permissions = array();
        $routes = Route::getRoutes()->getRoutesByName();
        $permissions = Roles::modifyRoutesData($routes);
        return view("users.roles.add", ["permissions" => $permissions]);
    }

    /**
     * Обработка данных после заполнения формы добавления роли
     *
     * @param Request $request
     * @return $this
     */
    public function addPost(Request $request)
    {
        $this->validate($request, Roles::$validateProp);

        $permissions = Roles::modifyPermissionsData($request->permissions);

        Sentinel::getRoleRepository()->createModel()->create([
            "slug" => $request->slug,
            "name" => $request->name,
            "permissions" => $permissions,
        ]);

        return redirect()
            ->route('roleList')
            ->withInput();
    }

    /**
     * Страница с для редактирования роли
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $role = Sentinel::getRoleRepository()->findById($id);
        $routes = Route::getRoutes()->getRoutesByName();
        $permissions = Roles::modifyRoutesData($routes);

        return view("users.roles.add", ["role" => $role, "permissions" => $permissions]);
    }

    /**
     * Обработка запроса на обновление данных роли
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editPost(Request $request, int $id)
    {
        $this->validate($request, Roles::$validateProp);

        $permissions = Roles::modifyPermissionsData($request->permissions);

        $role = Sentinel::getRoleRepository()->findById($id);
        $role->update([
            "slug" => $request->slug,
            "name" => $request->name,
            "permissions" => $permissions,
        ]);

        return redirect()->route('roleList');
    }

    /**
     * Удаление роли
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id)
    {
        $role = Sentinel::getRoleRepository()->findById($id);
        $role->delete();
        return redirect()->route('roleList');
    }
}
