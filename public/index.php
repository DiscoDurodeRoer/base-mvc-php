<?php

require_once("../app/index.php");

spl_autoload_extensions('.php');
spl_autoload_register();

$router = new Router();

$router->register(new Route('/^\/' . BASE_URL . '\/categoria\/(\w[\-\w]*)$/', 'CategoryController', 'display'));

// Login
$router->register(new Route('/^\/' . BASE_URL . '\/login-form$/', 'LoginController', 'display'));
$router->register(new Route('/^\/' . BASE_URL . '\/login$/', 'LoginController', 'login'));
$router->register(new Route('/^\/' . BASE_URL . '\/remember$/', 'LoginController', 'remember'));
$router->register(new Route('/^\/' . BASE_URL . '\/remember-form$/', 'LoginController', 'display_remember'));

// Users
$router->register(new Route('/^\/' . BASE_URL . '\/register-form$/', 'UserController', 'display'));
$router->register(new Route('/^\/' . BASE_URL . '\/register$/', 'UserController', 'register'));
$router->register(new Route('/^\/' . BASE_URL . '\/user-verification\/(\w+)$/', 'UserController', 'verification'));
$router->register(new Route('/^\/' . BASE_URL . '\/profile$/', 'UserController', 'display_profile'));

$router->register(new Route('/^\/' . BASE_URL . '\/perfil$/', 'UserController', 'display_profile'));
$router->register(new Route('/^\/' . BASE_URL . '\/editar-perfil-form$/', 'UserController', 'display_edit_profile'));
$router->register(new Route('/^\/' . BASE_URL . '\/editar-perfil$/', 'UserController', 'edit_profile'));
$router->register(new Route('/^\/' . BASE_URL . '\/editar-password-form$/', 'UserController', 'edit_password'));
$router->register(new Route('/^\/' . BASE_URL . '\/editar-password\/(\w+)$/', 'UserController', 'edit_password'));
$router->register(new Route('/^\/' . BASE_URL . '\/change_password$/', 'UserController', 'change_password'));
$router->register(new Route('/^\/' . BASE_URL . '\/verificacion-form$/', 'UserController', 'display_verification'));
$router->register(new Route('/^\/' . BASE_URL . '\/desuscribirse-confirm$/', 'UserController', 'display_unsubscribe'));

$router->register(new Route('/^\/' . BASE_URL . '\/desuscribirse$/', 'UserController', 'unsubscribe'));
$router->register(new Route('/^\/' . BASE_URL . '\/no-desuscribirse$/', 'UserController', 'no_unsubscribe'));
$router->register(new Route('/^\/' . BASE_URL . '\/logout$/', 'UserController', 'logout'));
$router->register(new Route('/^\/' . BASE_URL . '\/reenviar-confirmacion$/', 'UserController', 'resend_confirmation'));

// admin
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/categorias\/crear-categoria$/', 'AdminCategoryController', 'create_category'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/categorias\/crear-categoria-form$/', 'AdminCategoryController', 'display_create'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/categorias\/editar-categoria$/', 'AdminCategoryController', 'edit_category'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/categorias\/editar-categoria-form\/(\w+)$/', 'AdminCategoryController', 'display_edit'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/categorias\/eliminar-categoria\/(\w+)$/', 'AdminCategoryController', 'delete_category'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/categorias(\/\w+)?$/', 'AdminCategoryController', 'display'));

$router->register(new Route('/^\/' . BASE_URL . '\/admin\/log\/delete-log$/', 'AdminLogController', 'delete_content_log'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/log$/', 'AdminLogController', 'display'));

$router->register(new Route('/^\/' . BASE_URL . '\/admin\/back$/', 'AdminController', 'back'));

$router->register(new Route('/^\/' . BASE_URL . '\/admin\/user\/no-banear\/(\w+)$/', 'AdminUserController', 'no_ban_user'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/user\/banear\/(\w+)$/', 'AdminUserController', 'ban_user'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/user\/desactivar\/(\w+)$/', 'AdminUserController', 'no_act_user'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/user\/activar\/(\w+)$/', 'AdminUserController', 'act_user'));
$router->register(new Route('/^\/' . BASE_URL . '\/admin\/user(\/\w+)?$/', 'AdminUserController', 'display'));

$router->register(new Route('/^\/' . BASE_URL . '\/admin$/', 'AdminCategoryController', 'display'));

// search
$router->register(new Route('/^\/' . BASE_URL . '\/busqueda\/(.*)$/', 'SearchController', 'display'));
$router->register(new Route('/^\/' . BASE_URL . '\/procesar-busqueda$/', 'SearchController', 'proccess_search'));

$router->register(new Route('/^\/' . BASE_URL . '/', 'CategoryController', 'display'));
$router->handleRequest($_SERVER['REQUEST_URI']);
