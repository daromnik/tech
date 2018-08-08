<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Sentinel;

class AuthController extends Controller
{
    /**
     * Страница с формой авторизации пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view("users.index");
    }

    /**
     * Метод для аутификации пользователя
     *
     * Обрабтка данных с формы для входа на сайт
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",
            "password" => "required",
        ]);

        try {
            $remember = (bool) $request->get('remember', false);
            if (Sentinel::authenticate($request->all(), $remember)) {
                return redirect()->route("userList");
            } else {
                $err = __("auth.us_or_pass_incorrect");
            }
        } catch (NotActivatedException $e) {
            $err = __("auth.account_not_activated");
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $err = __("auth.account_locked", ["seconds" => $delay]);
        }

        return redirect()->back()
                ->withInput()
                ->with('err', $err);
    }

    /**
     * Метод для разлогиневания пользователя
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Sentinel::logout();
        return redirect()->route("login");
    }
}
