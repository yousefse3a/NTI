<?php
include('blog.php');
include('helper.php');

$db_obj = new DBclass;
$help_obj= new helper;
$id = $_GET['id'];
$op=$db_obj->dbquery("select * from blog where id = $id");

if (mysqli_num_rows($op) == 1) {
    $data = mysqli_fetch_assoc($op);
    $file_path = $data['File_Path'];
    $query = "delete from blog where id = $id ";
    $op=$db_obj->dbquery($query);
    if ($op) {
        $message = 'raw deleted';
        unlink($file_path);
    } else {
        $message = 'error Try Again !!!!!! ';
    }
}
$_SESSION['Message'] = $message;
header('Location:' . $help_obj->url('index.php'));
