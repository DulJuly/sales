<?php
/**
 * Created by PhpStorm.
 * User: leevare
 * Date: 2017/9/21
 * Time: 11:18
 */

namespace App\Controller;

class installController extends Base {

    public function install($req, $resp) {
        $this->db->schema()->dropIfExists('users');
        $this->db->schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('username', 50);
            $table->string('password', 255);
            $table->timestamps();
        });

        return $resp->write('安装成功！');
    }
}