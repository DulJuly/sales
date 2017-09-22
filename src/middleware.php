<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(new \App\Middleware\ValidationMiddleware($container));
$app->add(new \App\Middleware\CsrfMiddleware($container));
$app->add($container->csrf);