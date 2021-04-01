<?php

require_once("../app/index.php");

spl_autoload_extensions('.php');
spl_autoload_register();

$router = new Router();

$router->register(new Route('/^\/base-mvc-php\/categoria\/(\w[\-\w]*)$/', 'CategoryController', 'display'));

// Login
$router->register(new Route('/^\/base-mvc-php\/login-form$/', 'LoginController', 'display'));
$router->register(new Route('/^\/base-mvc-php\/login$/', 'LoginController', 'login'));
$router->register(new Route('/^\/base-mvc-php\/remember$/', 'LoginController', 'remember'));
$router->register(new Route('/^\/base-mvc-php\/remember-form$/', 'LoginController', 'display_remember'));

// Users
$router->register(new Route('/^\/base-mvc-php\/register-form$/', 'UserController', 'display'));
$router->register(new Route('/^\/base-mvc-php\/register$/', 'UserController', 'register'));
$router->register(new Route('/^\/base-mvc-php\/user-verification\/(\w+)$/', 'UserController', 'verification'));
$router->register(new Route('/^\/base-mvc-php\/profile$/', 'UserController', 'display_profile'));

$router->register(new Route('/^\/base-mvc-php\/perfil$/', 'UserController', 'display_profile'));
$router->register(new Route('/^\/base-mvc-php\/editar-perfil-form$/', 'UserController', 'display_edit_profile'));
$router->register(new Route('/^\/base-mvc-php\/editar-perfil$/', 'UserController', 'edit_profile'));
$router->register(new Route('/^\/base-mvc-php\/editar-password-form$/', 'UserController', 'edit_password'));
$router->register(new Route('/^\/base-mvc-php\/editar-password\/(\w+)$/', 'UserController', 'edit_password'));
$router->register(new Route('/^\/base-mvc-php\/change_password$/', 'UserController', 'change_password'));
$router->register(new Route('/^\/base-mvc-php\/verificacion-form$/', 'UserController', 'display_verification'));
$router->register(new Route('/^\/base-mvc-php\/desuscribirse-confirm$/', 'UserController', 'display_unsubscribe'));

$router->register(new Route('/^\/base-mvc-php\/desuscribirse$/', 'UserController', 'unsubscribe'));
$router->register(new Route('/^\/base-mvc-php\/no-desuscribirse$/', 'UserController', 'no_unsubscribe'));
$router->register(new Route('/^\/base-mvc-php\/logout$/', 'UserController', 'logout'));
$router->register(new Route('/^\/base-mvc-php\/reenviar-confirmacion$/', 'UserController', 'resend_confirmation'));

// admin
$router->register(new Route('/^\/base-mvc-php\/admin\/categorias\/crear-categoria$/', 'AdminCategoryController', 'create_category'));
$router->register(new Route('/^\/base-mvc-php\/admin\/categorias\/crear-categoria-form$/', 'AdminCategoryController', 'display_create'));
$router->register(new Route('/^\/base-mvc-php\/admin\/categorias\/editar-categoria$/', 'AdminCategoryController', 'edit_category'));
$router->register(new Route('/^\/base-mvc-php\/admin\/categorias\/editar-categoria-form\/(\w+)$/', 'AdminCategoryController', 'display_edit'));
$router->register(new Route('/^\/base-mvc-php\/admin\/categorias\/eliminar-categoria\/(\w+)$/', 'AdminCategoryController', 'delete_category'));
$router->register(new Route('/^\/base-mvc-php\/admin\/categorias(\/\w+)?$/', 'AdminCategoryController', 'display'));

$router->register(new Route('/^\/base-mvc-php\/admin\/log\/delete-log$/', 'AdminLogController', 'delete_content_log'));
$router->register(new Route('/^\/base-mvc-php\/admin\/log$/', 'AdminLogController', 'display'));

$router->register(new Route('/^\/base-mvc-php\/admin\/back$/', 'AdminController', 'back'));

$router->register(new Route('/^\/base-mvc-php\/admin\/user\/no-banear\/(\w+)$/', 'AdminUserController', 'no_ban_user'));
$router->register(new Route('/^\/base-mvc-php\/admin\/user\/banear\/(\w+)$/', 'AdminUserController', 'ban_user'));
$router->register(new Route('/^\/base-mvc-php\/admin\/user\/desactivar\/(\w+)$/', 'AdminUserController', 'no_act_user'));
$router->register(new Route('/^\/base-mvc-php\/admin\/user\/activar\/(\w+)$/', 'AdminUserController', 'act_user'));
$router->register(new Route('/^\/base-mvc-php\/admin\/user(\/\w+)?$/', 'AdminUserController', 'display'));

$router->register(new Route('/^\/base-mvc-php\/admin$/', 'AdminCategoryController', 'display'));

// search
$router->register(new Route('/^\/base-mvc-php\/busqueda\/(.*)$/', 'SearchController', 'display'));
$router->register(new Route('/^\/base-mvc-php\/procesar-busqueda$/', 'SearchController', 'proccess_search'));

$router->register(new Route('/^\/base-mvc-php/', 'CategoryController', 'display'));
$router->handleRequest($_SERVER['REQUEST_URI']);
