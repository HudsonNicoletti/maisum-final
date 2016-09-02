<?php

#   FRONTEND BASIC

$router->add("/", [
    'module'     => 'Frontend',
    'namespace'  => 'Frontend\Controllers',
    'controller' => 'index',
    'action'     => 'index',
]);

$router->add("/:controller", [
    'module'     => 'Frontend',
    'namespace'  => 'Frontend\Controllers',
    'controller' => 1,
]);

$router->add("/:controller/:action", [
    'module'     => 'Frontend',
    'namespace'  => 'Frontend\Controllers',
    'controller' => 1,
    'action'     => 2,
]);

$router->add("/:controller/:action/:params", [
    'module'     => 'Frontend',
    'namespace'  => 'Frontend\Controllers',
    'controller' => 1,
    'action'     => 2,
    'params'     => 3,
]);

$router->add("/contact", [
    'controller' => 'index',
    'action'     => 'contact',
]);

$router->add("/register/:action", [
    'controller' => 'register',
    'action'     => 1,
]);

$router->add("/newsletter", [
    'controller' => 'index',
    'action'     => 'newsletter',
]);

$router->add("/blog/{urlrequest:[a-zA-Z0-9\_\-]+}", [
    'controller' => 'blog',
    'action'     => 'post',
]);

$router->add("/blog/comment/{urlrequest:[a-zA-Z0-9\_\-]+}", [
    'controller' => 'blog',
    'action'     => 'comment',
]);
