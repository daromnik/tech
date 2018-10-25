<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Role;
use Route;

class RolesController extends Controller
{
    /**
     * Получение валидатора для входящего запроса на добавление/редактирование роли.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|min:3|max:15',
            'slug' => 'required|min:3|max:15',
        ]);
    }

    /**
     * Страница списка всех ролей пользователей
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view("users.roles.list", ["roles" => $roles]);
    }

    /**
     * Страница формы добавления новой роли пользователя
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $routes = Route::getRoutes()->getRoutesByName();
        $permissions = Role::modifyRoutesData($routes);
        return view("users.roles.add", ["permissions" => $permissions]);
    }

    /**
     * Метод для валидации формы и получние прав пользователя
     *
     * @param Request $request
     * @return array
     */
    protected function validateAndGetPermissions(Request $request)
    {
        $this->validator($request->all())->validate();

        $permissions = array();
        if(!empty($request->permissions))
        {
            $permissions = json_encode(Role::modifyPermissionsData($request->permissions));
        }

        return $permissions;
    }

    /**
     * Обработка данных после заполнения формы добавления роли
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permissions = $this->validateAndGetPermissions($request);

        Role::create([
            "slug" => $request->slug,
            "name" => $request->name,
            "permissions" => $permissions,
        ]);

        return redirect()
            ->route('roles.index')
            ->withInput();
    }

    /**
     * Страница с для редактирования роли
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $routes = Route::getRoutes()->getRoutesByName();
        $permissions = Role::modifyRoutesData($routes);

        $role->permissions = json_decode($role->permissions, true);
        return view("users.roles.add", ["role" => $role, "permissions" => $permissions]);
    }

    /**
     * Обработка запроса на обновление данных роли
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $permissions = $this->validateAndGetPermissions($request);

        $role->update([
            "slug" => $request->slug,
            "name" => $request->name,
            "permissions" => $permissions,
        ]);

        return redirect()->route('roles.index');
    }

    /**
     * Удаление роли
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index');
    }
}
