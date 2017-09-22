<?php
/**
 * Created by PhpStorm.
 * User: leevare
 * Date: 2017/9/22
 * Time: 11:10
 */

namespace App\Middleware;


class CsrfMiddleware extends Middleware {

    public function __invoke($req, $resp, $next) {
        $this->container->renderer->getEnvironment()->addGlobal('csrf', [
            'TokenNameKey' => $this->container->csrf->getTokenNameKey(),
            'TokenName' => $this->container->csrf->getTokenName(),
            'TokenValueKey' => $this->container->csrf->getTokenValueKey(),
            'TokenValue' => $this->container->csrf->getTokenValue(),
        ]);
        $resp = $next($req, $resp);
        return $resp;
    }
}