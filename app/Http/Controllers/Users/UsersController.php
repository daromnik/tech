<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Sentinel;

class UsersController extends Controller
{
    /**
     * Страница списка всех пользователей
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $users = User::all();
        return view("users.list", ["users" => $users]);
    }

    /**
     * Страница формы добавления пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $roles = Role::all();
        return view("users.add", ["roles" => $roles]);
    }

    /**
     * Обработка данных после заполнения формы добавления пользователя
     *
     * @param Request $request
     * @return $this
     */
    public function addPost(Request $request)
    {
        User::validator($request->all())->validate();

        $user = Sentinel::registerAndActivate($request->all());
        $user->roles()->attach($request->role);

        return redirect()
            ->route('userList')
            ->withInput();
    }

    /**
     * Страница с для редактирования пользователя
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $user = User::find($id);
        $userRole = $user->roles()->first();
        $roles = Role::all();
        return view("users.add", ["user" => $user, "userRole" => $userRole->id, "roles" => $roles]);
    }

    /**
     * Обработка запроса на обновление данных пользователя
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editPost(Request $request, int $id)
    {
        User::validator($request->all(), true)->validate();

        try
        {
            $data = $request->post();
            if(empty($data["password"]))
            {
                unset($data["password"]);
                unset($data["password_confirmation"]);
            }

            $user = User::find($id);
            $user->update($data);

            if(!$user->inRole($data["role"]))
            {
                $user->roles()->sync([$data["role"]]);
            }

            return redirect()->route('userList');
        }
        catch (\Exception $e)
        {
            \Log::info($e->getMessage());
            return redirect()
                ->route('userEdit', ["id" => $id])
                ->with("err", "Что-то пошло не так. Попробуйте снова или обратитесь к администратору сайта.");
        }
    }

    /**
     * Удаление пользователя
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('userList');
    }
}
