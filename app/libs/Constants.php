<?php

define("BASE_URL", "base-mvc-php");

define("BASE_URL_ROUTE", "/" . BASE_URL . "/");

define("PAGE_URL", "http://localhost:8080/" . BASE_URL ."/public/");

define("PATH_IMG", PAGE_URL . "img/");
define("PATH_LOG", "../app/log/");
define("FILE_LOG", "log.txt");

define("NUM_ITEMS_PAG", 10);
define("HASH_PASS_KEY", "discoduroderoer");

define("SESSION_ID_USER", "id");
define("SESSION_IS_ADMIN", "isAdmin");

define("TYPE_USER_DEFAULT", 1);

define("TRUE", "1");
define("FALSE", "0");

define("IS_ADMIN", "1");
define("IS_USER", "2");

define("ALL_CATEGORIES", "1");
define("ONLY_PARENTS", "2");
define("ONLY_CHILDS", "3");

define("ERROR_GENERAL", "Ha ocurrido un error, contacte con el administrador");
define("MODE_DEBUG", "1");
define("ERROR_LOG", "E");
define("INFO_LOG", "I");

define("DEFAULT_AVATAR", PAGE_URL . "img/default-avatar.jpg");

define("LENGTH_USER_KEY", 20);
define("USER_KEY_NUMBER", 0);
define("USER_KEY_MAYUS", 1);
define("USER_KEY_MINUS", 2);

define("NEED_VERIFICATION_USER", "0");

// BD

define("HOST", "localhost");
define("USUARIO", "root");
define("PASS", "");
define("DB", "base-mvc-php");

//  Conf Email

define("EMAIL_HOST", "smtp.mailtrap.io");
define("EMAIL_USERNAME", "8aba630f0ba7e7");
define("EMAIL_PASS", "407377b27bbf2c");
define("EMAIL_SMTPSECURE", "tls");
define("EMAIL_PORT", 2525);
define("EMAIL_ADMIN", 'ddr-288a24@inbox.mailtrap.io');

// Plantillas

define("TEMPLATE_NEW_ACCOUNT_NEED_VERIFICATION", __DIR__ . "/../templates_email/create_new_account_need_verification.html");
define("TEMPLATE_NEW_ACCOUNT_SUCCESS", __DIR__ . "/../templates_email/create_new_account_success.html");
define("TEMPLATE_EDIT_PASSWORD", __DIR__ . "/../templates_email/edit_password.html");

// Search

define("TABLE_SEARCH", "");
define("FIELD_ID_SEARCH", "");
define("FIELD_SEARCH", "");
define("PATH_SEARCH", "");