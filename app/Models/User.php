<?php

namespace App\Models;

use Illuminate\Support\Facades\Validator;
use Cartalyst\Sentinel\Users\EloquentUser;

class User extends EloquentUser
{
    /**
     * Получение валидатора для входящего запроса на добавление/редактирование пользователя.
     *
     * @param  array $data
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

}
