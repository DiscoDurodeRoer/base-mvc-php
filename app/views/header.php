<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo BASE_URL_ROUTE ?>public/includes/bootstrap-4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL_ROUTE ?>public/includes/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL_ROUTE ?>public/css/styles.css">
    <link href="<?php echo BASE_URL_ROUTE ?>public/includes/ckeditor4/plugins/codesnippet/lib/highlight/styles/monokai_sublime.css" rel="stylesheet">
    <title>MVC Base</title>

</head>

<body>

    <div class="row-no-gutters" id="header">
        <!-- Cabecera -->
        <!-- <div class="row" id=""> -->
        <div class="col-12">
            <!-- Menu -->

            <div class="container">

                <div class="row">
                    <div class="col-lg-4 col-12 block-logo">
                        <a class="navbar-brand" href="index.php">
                            
                        </a>
                    </div>
                    <div class="col-lg-8 col-12 mt-2 block-buttons">

                        <?php

                        if (isset($data) && $data['login']) {

                            $nickname = $data['nickname'];

                        ?>

                            <span class="greeting mr-3">Hola, <?php echo $nickname ?></span>

                            <?php

                            include "block-search.php";
                            if ($data['isAdmin']) {
                            ?>
                                <a class="btn btn-success btn-icon" href="<?php echo BASE_URL_ROUTE ?>admin">
                                    <i class="fa fa-home" aria-hidden="true"></i>Admin
                                </a>
                            <?php
                            }

                            ?>

                            <a class="btn btn-info btn-icon btn-xs-block" href="<?php echo BASE_URL_ROUTE ?>perfil">
                                <i class="fa fa-user" aria-hidden="true"></i>Ver perfil
                            </a>

                            <a class="btn btn-danger btn-icon btn-xs-block" href="<?php echo BASE_URL_ROUTE ?>logout">
                                <i class="fa fa-power-off" aria-hidden="true"></i>Logout
                            </a>

                        <?php
                        } else {

                            include "block-search.php";
                        ?>

                            <a class="btn btn-primary btn-icon" href="<?php echo BASE_URL_ROUTE ?>register-form">
                                <i class="fa fa-sign-in" aria-hidden="true"></i>Registrarse
                            </a>
                            <a class="btn btn-success btn-icon" href="<?php echo BASE_URL_ROUTE ?>login-form">
                                <i class="fa fa-user" aria-hidden="true"></i>Iniciar sesión
                            </a>
                        <?php
                        }
                        ?>



                    </div>
                </div>



            </div>

        </div>
    </div>

    <!-- Contenido -->
    <div class="row-no-gutters vh-100" id="content">
        <div class="col-12">
            <div class="container">
                <div class="content-start">

                    <?php
                    include_once "show-info-message.php";
                    ?>