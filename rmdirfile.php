<?php
session_start();
$current_dir = $_SESSION["current_dir"];
$host = $_SESSION["HTTP_Host"];
$dir_path = $_GET['dir'];
$file_path = $_GET['file'];
if (empty($file_path)) {
    function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object)) {
                        rrmdir($dir."/".$object);
                    } else {
                        unlink($dir."/".$object);
                    }
                }
            }
            rmdir($dir);
        }
    };
    rrmdir($dir_path);
    header("Location: /?dir=".$current_dir);
} else {
    unlink($file_path);
    header("Location: http://".$host."/?dir=".$current_dir);
}
?>