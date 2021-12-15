<?php 
include('dbconnection.php');
include('helpers.php');
session_start();
$id = $_GET['id'];

$query = "select * from todo_list where id = $id";
$op   = mysqli_query($con,$query);

if(mysqli_num_rows($op) == 1){
   $data = mysqli_fetch_assoc($op);
   $file_path=$data['FilePath'];
   $query = "delete from todo_list where id = $id ";
   $op  = mysqli_query($con,$query);
   if($op){
    $message = 'raw deleted';
    unlink($file_path);
   }else{
    $message = 'error Try Again !!!!!! ';
   }
}
$_SESSION['Message']=$message;
header("Location: review.php");
?>