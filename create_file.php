<?php
session_start();
$current_dir = $_SESSION["current_dir"];
$host = $_SESSION["HTTP_Host"];
if (isset($_POST['create'])) {
    $fileName = $_POST['fileName'];

    if (!empty($fileName)) {
        $targetFile = $current_dir . '/' . $fileName;
        $file = fopen($targetFile, "w");
        if ($file) {
            fwrite($file, 'File Created, Please Edit!');
            fclose($file);
            header("Location: /?dir=".$current_dir);
        } else {
            header("Location: /?dir=".$current_dir);
        }
    } else {
        echo "Please enter a File name.";
    }
}
?>