<?php
session_start();
$current_dir = $_SESSION["current_dir"];
$host = $_SESSION["HTTP_Host"];
if (isset($_POST['create'])) {
    $folderName = $_POST['folderName'];

    if (!empty($folderName)) {
        $targetDirectory = $current_dir . '/' . $folderName;

        if (!file_exists($targetDirectory)) {
            if (!mkdir($targetDirectory)) {
                echo "Failed to create directory: " . $targetDirectory;
            } else {
                echo "Directory created: " . $targetDirectory;
                header("Location: /?dir=".$current_dir);
            }
        } else {
            echo "Directory already exists: " . $targetDirectory;
        }
        // echo $targetDirectory;

    } else {
        echo "Please enter a folder name.";
    }
}
?>