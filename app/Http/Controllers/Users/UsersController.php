<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;

class UsersController extends Controller
{
    public function list()
    {

    }

    public function add()
    {
        return view("users.add");
    }

    public function addPost(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'email',
            'password' => 'required|confirmed|min:6',
        ]);

        Sentinel::registerAndActivate($request->all());

        return redirect()
                ->route('userList')
                ->withInput();
    }
}
