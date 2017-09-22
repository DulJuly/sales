<?php
/**
 * Created by PhpStorm.
 * User: leevare
 * Date: 2017/9/22
 * Time: 10:36
 */

namespace App\Auth;


use App\Model\User;

class Auth {
    public function user() {
        $user = User::find($_SESSION['AUth']);
        return $user;
    }

    public function logout() {
        unset($_SESSION['Auth']);
    }

    public function userExist($username, $password) {
        $user = User::query()->where('username', $username)->first();
        if(!$user)
            return false;

        if(password_verify($password, $user->password)) {
            $_SESSION['Auth'] = $user->id;
            return true;
        }
    }

    public function userCheck() {
        return isset($_SESSION['Auth']);
    }
}