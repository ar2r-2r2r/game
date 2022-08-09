<?php

Router::page('/login', 'login.php');
Router::page('/register', 'register.php');
Router::page('/', 'home.php');
Router::page('/game', 'index.html');

Router::post('/auth/register',UserController::class,'register');
Router::post('/auth/login',UserController::class,'login');

Router::get('/logout',UserController::class,'logout');

Router::enable();