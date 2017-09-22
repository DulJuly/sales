<?php
/**
 * Created by PhpStorm.
 * User: leevare
 * Date: 2017/9/22
 * Time: 10:43
 */

namespace App\Middleware;


class Middleware {
    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }
}