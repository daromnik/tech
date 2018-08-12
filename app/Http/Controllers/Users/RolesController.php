<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Users;
use App\Models\Roles;
use Route;
use Sentinel;

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
        $routes = Route::getRoutes()->getRoutesByName();
        $permissions = Roles::modifyRoutesData($routes);
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
            $permissions = Roles::modifyPermissionsData($request->permissions);
        }

        return $permissions;
    }

    /**
     * Обработка данных после заполнения формы добавления роли
     *
     * @param Request $request
     * @return $this
     */
    public function addPost(Request $request)
    {
        $permissions = $this->validateAndGetPermissions($request);

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
        $permissions = $this->validateAndGetPermissions($request);

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
