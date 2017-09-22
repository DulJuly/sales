<?php
/**
 * Created by PhpStorm.
 * User: leevare
 * Date: 2017/9/22
 * Time: 10:44
 */

namespace App\Middleware;


class AuthMiddleware extends Middleware {

    public function __invoke($req, $resp, $next) {
        if (!$this->container->Auth->userCheck()) {
            return $resp->withRedirect($this->container->router->pathFor('user.login'));
        }

        $resp = $next($req, $resp);
        return $resp;
    }
}