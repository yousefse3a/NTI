<?php 
include('DBconnect.php');
include('helpers.php');
session_start();
$id = $_GET['id'];
if(!validate($id,4)){
    $message =  'Invalid Number'.validate($id,4);
}else{

   $query = "select * from blog where id = $id";
   $op   = mysqli_query($con,$query);
     if(mysqli_num_rows($op) == 1){
   

   $query = "delete from blog where id = $id ";
   $op  = mysqli_query($con,$query);

   if($op){
    $message = 'raw deleted';
    del_img($id);
   }else{
    $message = 'error Try Again !!!!!! ';
   }
}else{
    $message = 'Error In User Id ';
}
}

   $_SESSION['Message'] = $message;
   header("Location: Review.php");


?>