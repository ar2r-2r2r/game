<?php

session_start();
$login=$_SESSION['user'];
$level=$_POST['level'];
$conn = new mysqli("localhost", "root", "", "game");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}
$sql="UPDATE users SET level = $level WHERE login='$login'";
$conn->query($sql);

echo $level;
