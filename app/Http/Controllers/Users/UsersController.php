<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
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
        $users = Users::getAllUsersWithRoles();
        return view("users.list", ["users" => $users]);
    }

    /**
     * Страница формы добавления пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $roles = Users::getAllRoles();
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
        $this->validate($request, [
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'email',
            'role' => 'required|integer',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = Sentinel::registerAndActivate($request->all());
        $user->roles()->attach($request->role);

        return redirect()
            ->route('userList')
            ->withInput();
    }

    public function update(int $id)
    {
        $user = Sentinel::findById($id);
        $userRole = $user->roles()->first();
        $roles = Users::getAllRoles();
        return view("users.add", ["user" => $user, "userRole" => $userRole->id, "roles" => $roles]);
    }

    public function updatePost(Request $request, int $id)
    {
        $this->validate($request, [
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'email',
            'role' => 'required|integer',
            'password' => 'nullable|confirmed|min:6',
        ]);

        try
        {
            $data = $request->post();
            if(empty($data["password"]))
            {
                unset($data["password"]);
                unset($data["password_confirmation"]);
            }

            /**
             * @param \Cartalyst\Sentinel\Users\EloquentUser $user
             */
            $user = Sentinel::findById($id);
            Sentinel::update($user, $data);

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
                ->route('userUpdate', ["id" => $id])
                ->with("err", "Что-то пошло не так. Попробуйте снова или обратитесь к администратору сайта.");
        }
    }
}
