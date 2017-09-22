<?php
/**
 * Created by PhpStorm.
 * User: leevare
 * Date: 2017/9/21
 * Time: 11:19
 */

namespace App\Controller;


class Base {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __get($name) {
        if($this->container->{$name}) {
            return $this->container->{$name};
        }
    }
}