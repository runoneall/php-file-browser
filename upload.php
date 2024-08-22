<?php
session_start();
$current_dir = $_SESSION["current_dir"];
$host = $_SESSION["HTTP_Host"];
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // 检查文件大小 (如果你需要)
    if ($file['size'] > 1024*1024*40) {
        echo "文件太大，请上传小于 40MB 的文件。";
        exit;
    }

    // 保存文件
    $targetFile = (string)$current_dir . "/" . $file['name'];
    move_uploaded_file($file['tmp_name'], $targetFile);

    echo "文件上传成功！";
    // echo $current_dir;

    // header("Location: http://".$host."/?dir=".$current_dir);
    header("Location: /?dir=".$current_dir);
} else {
    echo "请选择要上传的文件。";
}

?>
