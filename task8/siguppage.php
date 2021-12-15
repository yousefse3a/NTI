<?php
include('dbconnection.php');
include('helpers.php');
session_start();
if($_SERVER['REQUEST_METHOD']=='POST'){
    $errors=[];
    $user_name   = $_POST['user_name'];
    $name   = $_POST['name'];
    $email   = $_POST['email'];
    $password  = $_POST['password'];
    $user_name=clean($user_name);
    $name=clean($name);

    if(!validate($user_name,1)){
        $errors['user_name']="name Required";
    }elseif(!validate($user_name,6)){
        $errors['user_name']="user name is taken";
    }
    
    if(!validate($name,1)){
        $errors['name']="name Required";
    }

    if(!validate($email,1)){
        $errors['email']="email Required";
    }elseif(!validate($email,2)){
        $errors['email']=" enter right email";
    }
    
    if(!validate($password,1)){
        $errors['password']="password Required";
    }elseif(!validate($password,3)){
        $errors['password']="password must > 6 char";
    }

    $password=md5($password);

    if(empty($errors)){
        $query ="INSERT INTO users (user_name,name,email,password)VALUES ('$user_name','$name','$email','$password')";
        $op= mysqli_query($con,$query);
        if(!$op){
            echo mysqli_error($con);
        }else{
            $query1 = "select * from users where  user_name = '$user_name'";
            $op1 =mysqli_query($con,$query1);
            if(!$op1){
                echo mysqli_error($con);
            }else{
                    $_SESSION['data']=mysqli_fetch_assoc($op1);
                    header("Location: review.php");
            }
        }
    }else{
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
 <h2>sign up</h2>
 <form action="<?php echo$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
 <div class="form-group">
   <label for="exampleInputName">User Name</label>
   <input type="text" class="form-control" id="exampleInputName"  name="user_name"   placeholder="Enter title">
 </div>
 <div class="form-group">
   <label for="exampleInputName">Name</label>
   <input type="text" class="form-control" id="exampleInputName"  name="name"   placeholder="Enter title">
 </div>
 <div class="form-group">
   <label for="exampleInputName">email</label>
   <input type="email" class="form-control" id="exampleInputName"  name="email"   placeholder="Enter title">
 </div>
 <div class="form-group">
   <label for="exampleInputEmail">password</label>
   <input type="password"   class="form-control" id="exampleInputEmail1" name="password"   placeholder="Enter content">
 </div>
 <button type="submit" class="btn btn-primary">sign up</button>
</form>
</div>
</body>
</html>