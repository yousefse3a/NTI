<?php
include('dbconnection.php');
include('helpers.php');
session_start();
if(!isset($_SESSION['data'])){
    header("Location: loginpage.php");
}else{
    $user_data=$_SESSION['data'];
    if($_SERVER['REQUEST_METHOD']=='POST'){
    $errors=[];
    $title   = $_POST['title'];
    $description  = $_POST['description'];
    $startdate  = $_POST['startdate'];
    $enddate  = $_POST['enddate'];

    $file_name =   $_FILES['fileToUpload']['name'];
    $file_type   =   $_FILES['fileToUpload']['type'];
    $file_tmp_path =$_FILES['fileToUpload']['tmp_name'];
    $file_name_arr=explode(".",$file_name);
    $file_extension=end($file_name_arr);

    $title=clean($title);
    $description=clean($description);

    if(!validate($title,1)){
        $errors['title']="title Required";
    }elseif(!validate($title,3)){
        $errors['title']="title must > 6 char";
    }

    if(!validate($description,1)){
        $errors['description']="description Required";
    }elseif(!validate($description,3)){
        $errors['description']="description must > 30";
    }

    if(!validate($startdate,1)){
        $errors['startdate']="startdate Required";
    }elseif(!validate($startdate,7)){
        $errors['startdate']="enter valid date";
    }

    if(!validate($enddate,1)){
        $errors['enddate']="enddate Required";
    }elseif(!validate($enddate,7)){
        $errors['enddate']="enter valid date";
    }


    if(!validate($file_name,1)){
        $errors['fileToUpload']="image required";   
    }
    elseif(!validate($file_extension,5)){
        $errors['fileToUpload']="file must be image";   
    }else{
        $FinalName = rand().time().'.'.$file_extension;
        $desPath = 'uploads/'.$FinalName;
     
             if(move_uploaded_file($file_tmp_path,$desPath)){
                 echo 'Image Uploaded';
             }else{
                 echo 'Error In Uploading file';
             }
    }
    if(empty($errors)){
        $v=$user_data['id'];
        $query = "INSERT INTO todo_list (title, description,startdate,enddate,FilePath,user_id )VALUES 
        ('$title', '$description','$startdate','$enddate','$desPath',$v)";
        $op= mysqli_query($con,$query);
        if(!$op){
            echo mysqli_error($con);
        }
        echo'row create';
        header("Location: review.php");
    }else{
        foreach($errors as $key => $value){
            echo($key.":".$value);
            echo("<br>");
        }
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
 <h2>create</h2>
 <form action="<?php echo$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
 <div class="form-group">
   <label for="exampleInputName">title</label>
   <input type="text" class="form-control" id="exampleInputName"  name="title"   placeholder="Enter title">
 </div>
 <div class="form-group">
   <label for="exampleInputName">description</label>
   <input type="text" class="form-control" id="exampleInputName"  name="description"   placeholder="Enter title">
 </div>
 <div class="form-group">
   <label for="exampleInputName">Date</label>
   <input type="date" class="form-control" id="exampleInputName"  name="startdate"   placeholder="start date">
   <input type="date" class="form-control" id="exampleInputName"  name="enddate"   placeholder="end  date">
 </div>
 <div class="form-group">
   <label for="exampleInputEmail">image</label>
   file:<input type="file" name="fileToUpload"><br>
 </div>
 <button type="submit" class="btn btn-primary">create</button>
</form>
</div>
</body>
</html>