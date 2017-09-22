<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/install/', 'App\Controller\installController:install')->setName('install');

$app->group('/user', function() {
    $this->get('/', 'App\Controller\UserController:index')->setName('user.index');
    $this->get('/customer', 'App\Controller\UserController:customer')->setName('user.customer');
    $this->get('/recommend', 'App\Controller\UserController:recommend')->setName('user.recommend');
    $this->post('/recommend', 'App\Controller\UserController:handleRecommend')->setName('user.handleRecommend');
    $this->get('/info', 'App\Controller\UserController:info')->setName('user.info');
    $this->get('/recommend/success', 'App\Controller\UserController:recommendSuccess')->setName('user.recommendSuccess');
    $this->get('/cash', 'App\Controller\UserController:cash')->setName('user.cash');
    $this->get('/message', 'App\Controller\UserController:message')->setName('user.message');
    $this->get('/logout', 'App\Controller\UserController:logout')->setName('user.logout');
})->add(new \App\Middleware\AuthMiddleware($container));

$app->group('/user', function() {
    $this->get('/login', 'App\Controller\UserController:login')->setName('user.login');
    $this->post('/login', 'App\Controller\UserController:loginTo')->setName('user.loginTo');
    $this->get('/register', 'App\Controller\UserController:register')->setName('user.register');
    $this->post('/register', 'App\Controller\UserController:registerTo')->setName('user.registerTo');
});

$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");
    //$args['name'] = htmlspecialchars($args['name']);
    // Render index view
    return $this->renderer->render($response, 'index.twig', $args);
});
