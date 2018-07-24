<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Sentinel;

class AuthController extends Controller
{
    public function index()
    {
        return view("users.index");
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",
            "password" => "required",
        ]);

        try {
            $remember = (bool) $request->get('remember', false);
            if (Sentinel::authenticate($request->all(), $remember)) {
                return redirect()->intended($this->redirectTo);
            } else {
                $err = "Имя пользователя или пароль неверны!";
            }
        } catch (NotActivatedException $e) {
            $err = "Ваша учетная запись не была активирована";
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $err = "Ваша учетная запись заблокирована на {$delay} sec";
        }

        return redirect()->back()
                ->withInput()
                ->with('err', $err);
    }
}
