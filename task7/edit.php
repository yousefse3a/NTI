<?php 
include('DBconnect.php');
include('helpers.php');
session_start();
   $id = $_GET['id'];
   $query = "select * from blog where id = $id";
   $op   = mysqli_query($con,$query);
     if(mysqli_num_rows($op) == 1){

        $data = mysqli_fetch_assoc($op);
     }else{
        $_SESSION['Message'] = "Access Denied";
        header("Location: Review.php");
     }
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $errors=[];
    $title   = $_POST['title'];
    $content  = $_POST['content'];

    $file_name =   $_FILES['fileToUpload']['name'];
    $file_type   =   $_FILES['fileToUpload']['type'];
    $file_tmp_path =$_FILES['fileToUpload']['tmp_name'];
    $file_name_arr=explode(".",$file_name);
    $file_extension=end($file_name_arr);

    

    $title=clean($title);
    $content=clean($content);

    if(!validate($title,1)){
        $errors['title']="title Required";
    }elseif(!validate($title,2)){
        $errors['title']="title must > 6 char";
    }

    if(!validate($content,1)){
        $errors['content']="content Required";
    }elseif(!validate($content,3)){
        $errors['content']="content must > 30";
    }

    if(!validate($file_name,1)){
        $errors['fileToUpload']="image required";   
    }
    elseif(!is_img($file_extension)){
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
        $query ="update blog set title = '$title', content = '$content',FilePath ='$desPath' where id=$id ";
        $op= mysqli_query($con,$query);
        if(!$op){
            echo mysqli_error($con);
        }
    }else{
        foreach($errors as $key => $value){
            echo($key.":".$value);
            echo("<br>");
        }
    }
    $_SESSION['Message'] = "edit item done";
    header("Location: Review.php");
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
 <h2>Edit </h2>


 <form  action="edit.php?id=<?php echo $data['id'];?>"   method="post" enctype="multipart/form-data" >

 <div class="form-group">
   <label for="exampleInputName">Name</label>
   <input type="text" class="form-control" id="exampleInputName"  name="title"  value="<?php echo $data['title'];?>"   placeholder="Enter title">
 </div>


 <div class="form-group">
   <label for="exampleInputEmail">Email address</label>
   <input type="text"   class="form-control" id="exampleInputEmail1" name="content" value="<?php echo $data['content'];?>" placeholder="Enter content">
 </div>
 <div class="form-group">
 <label for="exampleInputEmail">file</label>
 <input type="file" name="fileToUpload" value="<?php echo $data['FilePath']?>">
</div>

 
 <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>

</body>
</html>
