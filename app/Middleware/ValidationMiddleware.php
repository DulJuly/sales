<?php
/**
 * Created by PhpStorm.
 * User: leevare
 * Date: 2017/9/22
 * Time: 10:50
 */

namespace App\Middleware;


class ValidationMiddleware extends Middleware {

    public function __invoke($req, $resp, $next) {
        $this->container->renderer->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
        unset($_SESSION['errors']);
        $resp = $next($req, $resp);
        return $resp;
    }
}