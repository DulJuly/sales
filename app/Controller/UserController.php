<?php
/**
 * Created by PhpStorm.
 * User: leevare
 * Date: 2017/9/21
 * Time: 13:51
 */

namespace App\Controller;


use App\Model\User;
use Respect\Validation\Validator as validate;

class UserController extends Base {

    //首页
    public function index($req, $resp) {
        //user首页重定向
        return $resp->withStatus(301)->withHeader('Location', $this->router->pathFor('user.customer'));
    }

    //推荐客户
    public function customer($req, $resp, $args) {
        $x = $_SESSION['Auth'];
        $user = User::query()->find($x);
        return $this->renderer->render($resp, 'user/customer.twig', ['user' => $user]);
    }

    //推荐页面
    public function recommend($req, $resp, $args) {
        return $this->renderer->render($resp, 'user/recommend.twig');
    }

    //推荐处理
    public function handleRecommend($req, $resp, $args) {
        $data = $req->getParsedBody();
        $customer = trim($data['customer']);
        if (!$customer) return $this->renderer->render($resp, 'user/recommend.twig', ['error' => '推荐客户不能为空']);
        $res = array_merge($args, ['customer' => $customer]);
        return $this->renderer->render($resp, 'user/recommend_success.twig', $res);
    }

    //用户信息
    public function info($req, $resp) {
        return $this->renderer->render($resp, 'user/info.twig');
    }

    //推荐成功
    public function recommendSuccess($req, $resp, $args) {
        return $this->renderer->render($resp, 'user/recommend_success.twig', $args);
    }

    //领取奖金
    public function cash($req, $resp) {
        return $this->renderer->render($resp, 'user/cash.twig');
    }

    //消息中心
    public function message($req, $resp) {
        return $this->renderer->render($resp, 'user/message.twig');
    }

    //登录界面
    public function login($req, $resp) {
        return $this->renderer->render($resp, 'user/login.twig');
    }

    public function loginTo($req, $resp) {

        $validation = $this->Validator->validate($req, [
            'username' => validate::noWhitespace()->NotEmpty()->Alpha(),
            'password' => validate::noWhitespace()->NotEmpty(),
        ]);


        if ($validation->failed()) {
            return $resp->withRedirect($this->router->pathFor('user.login'));
        }

        $data = $req->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];
        $auth = $this->Auth->userExist($username, $password);
        if (!$auth) {
            return $resp->withRedirect($this->router->pathFor('user.login'));
        } else {
            return $resp->withRedirect($this->router->pathFor('user.index'));
        }
    }

    //登出
    public function logout($req, $resp) {
        $this->Auth->logout();
        return $resp->withRedirect($this->router->pathFor('user.login'));
    }

    //用户注册界面
    public function register($req, $resp) {
        return $this->renderer->render($resp, 'user/register.twig');
    }

    public function registerTo($req, $resp) {

        $validation = $this->Validator->validate($req, [
            'username' => validate::noWhitespace()->NotEmpty(),
            'password' => validate::noWhitespace()->NotEmpty(),
        ]);

        if ($validation->failed()) {
            return $resp->withRedirect($this->router->pathFor('user.register'));
        }

        $data = $req->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];
        $password1 = $data['password1'];
        if ($password !== $password1)
            return $this->renderer->render($resp, 'user/register.twig', ['error' => '两次密码输入不一致']);
        $user = User::query()->where('username', $username)->first();
        if ($user) return $this->renderer->render($resp, 'user/register.twig', ['error' => '用户名已被注册']);
        $insertId = User::query()->insertGetId([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        if ($insertId) return $this->renderer->render($resp, 'user/register.twig', ['msg' => '注册成功']);
        else return $this->renderer->render($resp, 'user/register.twig', ['error' => '注册失败']);
    }
}