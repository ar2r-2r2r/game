<?php

require_once('app/models/User.php');

class UserController
{
    
    public function __construct()
    {
    }

    function login($data)
    {
        $this->validateRequestFromAjax();

        $login = htmlspecialchars($data['login']);
        $password = htmlspecialchars($data['password']);

        $isLogin = false;

        $errors = [];

        if (empty($login)) {
            $errors[] = ['login_error_message' => 'Заполните поле логина'];
        }

        if (empty($password)) {
            $errors[] = ['password_error_message' => 'Заполните поле пароля'];
        }

        if (count($errors) > 0) {
            echo json_encode($errors);
            die();
        }
        $conn = new mysqli("localhost", "root", "", "game");
        if($conn->connect_error){
            die("Ошибка: " . $conn->connect_error);
        }
        $sql="SELECT * FROM users";
        $result=$conn->query($sql);
        foreach ($result as $user) {
            if ($user['login'] === $login && $user['password'] === md5($password . 'solid')) {
                session_start();
                $_SESSION['user'] = $login;
                $_SESSION['level']=$user['level'];
                setcookie('user', $user['login'], time() + 3600, "/");
                $isLogin = true;
                break;
            }
        }

        if ($isLogin == true) {
            echo json_encode(['path' => '/game']);
        } else {
            echo json_encode(['authorization_failed_message' => 'Неверный логин или пароль']);
        }
    }

    function logout()
    {
        $this->validateRequestFromAjax();
        if (isset($_SESSION['user'])) unset($_SESSION['user']);
        setcookie('user', $_COOKIE['user'], time() - 3600, "/");
        echo json_encode(['path' => '/']);
    }

    function register($data)
    {
        $this->validateRequestFromAjax();
        $login = htmlspecialchars($data['login']);
        $password = htmlspecialchars($data['password']);
        $level=1;
        $errors = [];

        if (!preg_match('/^[A-Za-z0-9]{2,}$/', $login) || empty($login)) {
            $errors[] = ['register_login_message' => 'Логин должен состоять более чем из 2 символов'];
        }

        if (!preg_match('/^\S*(?=\S{6,})(?=\S*[A-Za-z])(?=\S*[\d])\S*$/', $password) || empty($password)) {
            $errors[] = ['register_password_message' => 'Пароль должен состоять из более чем 6 символов и должен содержать хотя бы 1 букву и цифру'];
        }

        if ($this->findByLogin($data) != null) {
            $errors[] = ['register_exists_message' => 'Пользователь с таким логином уже существует'];
        }

        if (count($errors) > 0) {
            echo json_encode($errors);
            die();
        }

        $encryptedPassword = md5($password . 'solid');
        $user = new User($login, $encryptedPassword, $level);
        $conn = new mysqli("localhost", "root", "", "game");
        if($conn->connect_error){
            die("Ошибка: " . $conn->connect_error);
        }
        $sql="INSERT INTO users (login,password,level) VALUES ('".$login."','".$encryptedPassword."','".$level."')";
        $result=$conn->query($sql);
        echo json_encode(['path' => '/login']);
    }

    function findByLogin($data)
    {
        $conn = new mysqli("localhost", "root", "", "game");
        if($conn->connect_error){
            die("Ошибка: " . $conn->connect_error);
        }
        $sql="SELECT * FROM users";
        $result=$conn->query($sql);

        $this->validateRequestFromAjax();
        
        $login = htmlspecialchars(trim($data['login']));
        if ($result) {
            foreach ($result as $item) {
                if (strtolower($item['login']) === strtolower($login)) {
                    return json_encode(new User($item['login'],$item['password'], $item['level']));
                }
            }
        }
        return null;
    }

    private function validateRequestFromAjax()
    {
        if ($_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest' && empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            Router::redirectToNotAjaxRequest();
            exit;
        }
    }
}
