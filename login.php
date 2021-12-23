<?php
include('helpers.php');
include('dbconnection.php');
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $errors=[];
    $user_name   = $_POST['user_name'];
    $password  = $_POST['password'];
    $name=clean($user_name);
    $name=clean($password);
    $password= md5($password);

    if(!validate($user_name,1)){
        $errors['user_name']="user_name Required";
    }
    if(!validate($password,1)){
        $errors['password']="password Required";
    }

    if(empty($errors)){
        $query ="select * from app_users where user_name='$user_name' and password ='$password'";
        $op= mysqli_query($con,$query);
        if(!$op){
            echo mysqli_error($con);
        }
        elseif(mysqli_num_rows($op) > 0){
            $user_data=mysqli_fetch_assoc($op);
            $x=$user_data['role_id'];
            $query ="select * from role where id = $x";
            $op= mysqli_query($con,$query);
            if(!$op){
                echo mysqli_error($con);
            }
            else{
                $user_role=mysqli_fetch_assoc($op);
                switch($user_role['name']){
                    case 'admin':
                        $_SESSION['Admin_data']=$user_data;
                        header('Location:'.url('admin/adminView.php'));
                        break;
                    case 'emp':
                        $_SESSION['emp_data']=$user_data;
                        header('Location:'.url('employee/empView.php'));
                        break;
                    case 'client':
                        $_SESSION['client_data']=$user_data;
                        header('Location:'.url('client/clientView.php'));
                        break;
                    case 'delivery':
                        $_SESSION['delivery_data']=$user_data;
                        header('Location:'.url('delivery/deliveryView.php'));
                        break;
                }
            }            
        }
        else{
            echo 'No Matched Data !!!';
        }
    }
    else{
        foreach($errors as $key => $value){
            echo($key.":".$value);
            echo("<br>");
        }
    }



}
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <title>Edit</title>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
 <h2>login</h2>
 <form action="<?php echo$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
 <div class="form-group">
   <label for="exampleInputName">User Name</label>
   <input type="text" class="form-control" id="exampleInputName"  name="user_name"   placeholder="Enter title">
 </div>
 <div class="form-group">
   <label for="exampleInputEmail">password</label>
   <input type="text"   class="form-control" id="exampleInputEmail1" name="password"   placeholder="Enter content">
 </div>
 <button type="submit" class="btn btn-primary">login</button>
 <a href='siguppage.php' class='btn btn-danger m-r-1em'>sign up</a>
</form>
</div>
</body>
</html>