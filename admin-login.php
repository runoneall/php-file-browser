<?php
session_start();
$current_dir = $_SESSION["current_dir"];

// 登录信息
$username = "admin";
$password = "123456";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_username = $_POST["UserName"];
    $post_password = $_POST["Password"];

    if ($post_username == $username && $post_password == $password) {
        setcookie("is_login", "true", time() + (86400 * 10), "/");
        setcookie("username", $username, time() + (86400 * 10), "/");
        header("Location: admin-panel.php");
    } else {
        header("Location: /?dir=".$current_dir);
    }
}
?>