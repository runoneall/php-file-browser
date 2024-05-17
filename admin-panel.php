<?php
if(!isset($_COOKIE["is_login"])) {
    header("Location: /");
}
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>
    <style>
        a {
            color: blue;
        }
    </style>
</head>