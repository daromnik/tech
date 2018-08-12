<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Sentinel;
use Illuminate\Support\Facades\Redis;

class Users extends Model
{
    /**
     * Получение валидатора для входящего запроса на добавление/редактирование пользователя.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    static public function validator(array $data, $edit = false)
    {
        return Validator::make($data, [
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'email',
            'role' => 'required|integer',
            'password' => $edit ? 'nullable|confirmed|min:6' : 'required|confirmed|min:6',
        ]);
    }

    /**
     * Метод для получения все ролей пользователей
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    static public function getAllRoles()
    {
        return Sentinel::getRoleRepository()->all();
    }

    /**
     * Метод для получения всех пользователйй
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    static public function getAllUsers()
    {
        return Sentinel::getUserRepository()->all();
    }

    /**
     * Метод для получения всех пользователей вместе с ролями
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    static public function getAllUsersWithRoles()
    {
        //$users = Redis::get("users-with-roles");

        $users = Sentinel::getUserRepository()->with('roles')->get();

        //dd($users->toArray());

        //dd(collect(json_decode($users)));

        /*if ($users == null) {
            $users = Sentinel::getUserRepository()->with('roles')->get();

            dd($users);
            Redis::set("users-with-roles", $users);
        } else {
            $users = collect(json_decode($users));
        }*/

        return $users;
    }
}
