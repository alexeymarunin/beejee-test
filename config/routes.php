<?php

return [
    'index' => [
        'path'       => '/',
        'method'     => 'GET',
        'controller' => 'task',
        'action'     => 'index',
    ],
    'home' => [
        'path'       => '/home',
        'method'     => 'GET',
        'controller' => 'task',
        'action'     => 'index',
    ],

    'registerForm' => [
        'path'       => '/register',
        'method'     => 'GET',
        'controller' => 'user',
        'action'     => 'register',
    ],
    'userRegister' => [
        'path'       => '/register',
        'method'     => 'POST',
        'controller' => 'user',
        'action'     => 'register',
    ],
    'loginForm' => [
        'path'       => '/login',
        'method'     => 'GET',
        'controller' => 'user',
        'action'     => 'login',
    ],
    'userLogin' => [
        'path'       => '/login',
        'method'     => 'POST',
        'controller' => 'user',
        'action'     => 'login',
    ],
    'userLogout' => [
        'path'       => '/logout',
        'method'     => 'GET',
        'controller' => 'user',
        'action'     => 'logout',
    ],

    'tasks' => [
        'path'       => '/tasks',
        'method'     => 'GET',
        'controller' => 'task',
        'action'     => 'index',
    ],
    'viewTask' => [
        'path'       => '/task/[:id]',
        'method'     => 'GET',
        'controller' => 'task',
        'action'     => 'view',
    ],
    'taskCreateForm' => [
        'path'       => '/tasks/create',
        'method'     => 'GET',
        'controller' => 'task',
        'action'     => 'create',
    ],
    'taskCreate' => [
        'path'       => '/tasks/create',
        'method'     => 'POST',
        'controller' => 'task',
        'action'     => 'create',
    ],
    'taskUpdateForm' => [
        'path'       => '/task/[:id]/update',
        'method'     => 'GET',
        'controller' => 'task',
        'action'     => 'update',
    ],
    'taskUpdate' => [
        'path'       => '/task/[:id]/update',
        'method'     => 'POST',
        'controller' => 'task',
        'action'     => 'update',
    ],
    'taskAccept' => [
        'path'       => '/task/[:id]/accept',
        'method'     => 'GET',
        'controller' => 'task',
        'action'     => 'accept',
    ],
    'taskDelete' => [
        'path'       => '/task/[:id]/delete',
        'method'     => 'GET',
        'controller' => 'task',
        'action'     => 'delete',
    ],
    'imageUpload' => [
        'path'       => '/image/upload',
        'method'     => 'POST',
        'controller' => 'task',
        'action'     => 'upload',
    ],
];