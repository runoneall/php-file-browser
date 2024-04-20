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

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Files</title>
  <style>
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

<form action="create_dir.php" method="post" enctype="multipart/form-data">
    <input type="text" placeholder="新建文件夹" id="folderName" name="folderName" required>
    <input type="submit" name="create" value="创建">
</form>

<hr>

<ul>
  <?php foreach ($files as $file) : ?>
    <?php if ($file === '.' || $file === '..') continue; ?>
    <?php if (is_dir($current_dir . '/' . $file)) : ?>
      <li> 
        <a href="rmdirfile.php?dir=<?php echo $current_dir . '/' . $file; ?>">删除</a>
        <label>|</label>
        <a href="?dir=<?php echo $current_dir . '/' . $file; ?>"><?php echo $file; ?></a> 
      </li>
    <?php else : ?>
      <li> 
        <a href="rmdirfile.php?file=<?php echo $current_dir . '/' . $file; ?>">删除</a>
        <label>|</label>
        <a href="<?php echo $current_dir . '/' . $file; ?>"><?php echo $file; ?></a> 
      </li>
    <?php endif; ?>
  <?php endforeach; ?>
</ul>

<?php if ($current_dir !== $root_dir) : ?>
  <a href="?dir=<?php echo dirname($current_dir); ?>">返回上一级</a>
<?php endif; ?>

<?php
// echo $current_dir;
// echo "Host: " . $host;
$_SESSION["current_dir"] = $current_dir;
$_SESSION["HTTP_Host"] = $host;
?>


</body>
</html>