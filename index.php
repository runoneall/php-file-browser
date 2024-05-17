<?php
session_start();

// 定义根目录
$root_dir = './disk';

// 获取当前目录
$current_dir = $_GET['dir'] ?? $root_dir;

// 检查目录是否存在
if (!is_dir($current_dir)) {
    mkdir($current_dir);
}

// 读取当前目录下的文件和文件夹
$files = scandir($current_dir);

// 获取Host的值
$host = $_SERVER['HTTP_HOST'];

function is_binary($filename) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $filename);
    finfo_close($finfo);

    return strpos($mime_type, 'text') === false;
}

header('Content-Type: charset=utf-8');

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files</title>
    <style>
        a {
            color: blue;
        }
    </style>
</head>
<body style="
        background: lightgray;
">

<form action="upload.php" method="post" enctype="multipart/form-data">
        <label style="font-size: 15px;">上传文件</label>
        <input type="file" name="file" id="file">
        <progress id="progress" value="0" max="100"></progress>
        <input type="submit" value="上传" hidden>
</form>
<script>
        const fileInput = document.getElementById('file');
        const progressBar = document.getElementById('progress');
        const submitButton = document.querySelector('input[type="submit"]');

        fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                const formData = new FormData();
                formData.append('file', file);

                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload.php');
                xhr.upload.addEventListener('progress', (e) => {
                        const progress = Math.round((e.loaded / e.total) * 100);
                        progressBar.value = progress;

                        if (progress === 100) {
                                submitButton.click();
                        }
                });
                xhr.send(formData);
        });
</script>

<div style="display:flex">
    <form action="create_dir.php" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="新建文件夹" id="folderName" name="folderName" required>
            <input type="submit" name="create" value="创建">
    </form>
    &nbsp;&nbsp;&nbsp;
    <form action="create_file.php" method="post" enctype="multipart/form-data">
            <input type="text" placeholder="新建文件" id="fileName" name="fileName" required>
            <input type="submit" name="create" value="创建">
    </form>
</div>

<hr>

<ul>
    <?php foreach ($files as $file) : ?>
        <?php if ($file === '.' || $file === '..') continue; ?>
        <?php $path = $current_dir . '/' . $file; ?>
        <?php if (is_dir($path)) : ?>
            <li> 
                <a href="rmdirfile.php?dir=<?php echo $path; ?>">删除</a>
                <label>|</label>
                <a href="?dir=<?php echo $path; ?>"><?php echo $file; ?></a> 
            </li>
        <?php else : ?>
            <li> 
                <?php if (is_binary($path) == false) : ?>
                    <a href="edit_text.php?file=<?php echo $path; ?>">编辑</a>
                    <label>|</label>
                <?php endif; ?>
                <a href="rmdirfile.php?file=<?php echo $path; ?>">删除</a>
                <label>|</label>
                <a href="<?php echo $path; ?>"><?php echo $file; ?></a> 
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

<?php if ($current_dir !== $root_dir) : ?>
    <a href="?dir=<?php echo dirname($current_dir); ?>">返回上一级</a>
<?php endif; ?>

<hr>

<!-- <form action="admin-login.php" method="post" enctype="multipart/form-data">
    进入后台
    <input type="text" placeholder="用户名" id="UserName" name="UserName" required>
    <input type="password" placeholder="密码" id="Password" name="Password" required>
    <input type="submit" value="登录">
</form> -->

<?php
// echo $current_dir;
// echo "Host: " . $host;
$_SESSION["current_dir"] = $current_dir;
$_SESSION["HTTP_Host"] = $host;
?>


</body>
</html>
