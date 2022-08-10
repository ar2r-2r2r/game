<?php

session_start();
$a=$_SESSION['level'];
$login=$_SESSION['user'];
$conn = new mysqli("localhost", "root", "", "game");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}
$sql="SELECT * FROM users";
$result=$conn->query($sql);
foreach ($result as $user) {
    if ($user['login'] === $login) {
        $level=$user['level'];
        break;
    }
}

echo $level;
