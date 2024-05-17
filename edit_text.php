<?php
session_start();
$current_dir = $_SESSION["current_dir"];
$host = $_SESSION["HTTP_Host"];
?>

<?php if ($_SERVER["REQUEST_METHOD"] == "GET") : ?>
    <?php 
        $file_path = $_GET['file'];
        $file_content = file_get_contents($file_path);
    ?>
    <!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <style>
            textarea {
                width: 90%;
                height: 600px;
            }
            #FileName {
                border: none;
            }
            #FileName:focus {
                outline: none;
            }
            #inputField {
                border: 2px solid black;
                background-color: lightgray;
            }
        </style>
    </head>
    <body>
        <form action="edit_text.php" method="post">
            编辑
            <input type="text" id="FileName" name="FileName" 
                value=<?php echo $file_path ?> 
                size="<?php echo (strlen($file_path)/2) ?>" readonly>
            文件<br><br>
            <textarea id="inputField" name="inputField"><?php echo $file_content ?></textarea>
            <br>
            <input type="submit" value="提交">
        </form>
    </body>
<?php endif; ?>

<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $file_name = $_POST["FileName"];
    $inputContent = $_POST["inputField"];
    $file = fopen($file_name, "w");
    if ($file) {
        fwrite($file, $inputContent);
        fclose($file);
        header("Location: /?dir=".$current_dir);
    } else {
        header("Location: /?dir=".$current_dir);
    }
}
?>
