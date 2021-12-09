<?php
session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {  
        $name   = $_POST['Name'];
        $email  = $_POST['Email'];
        $linkedin = $_POST['linkedin'];
        $password = $_POST['Password'];
        $address  = $_POST['address'];
        $file_name =   $_FILES['fileToUpload']['name'];
        $file_type   =   $_FILES['fileToUpload']['type'];
        $file_tmp_path =$_FILES['fileToUpload']['tmp_name'];
        $errors=[];
        $extension_allow=['png','jpg','PNG','JPG'];


        $file_name_arr=explode(".",$file_name);
        $file_extension=end($file_name_arr);

        $FinalName = rand().time().'.'.$file_extension;





    
    # Validate Name ... 
    if(empty($name)){
        $errors['Name']  = "name Required";
    }
    # Validate Email ..... 
    if(empty($email)){
        $errors['Email'] = "email Required";
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['Email_Validate'] = "email not valid";
    }
    # Validate linkedin ..... 
    if(empty($linkedin)){
        $errors['linkedin'] = "linkedin url Required";
    }elseif(!filter_var($linkedin,FILTER_VALIDATE_URL)){
        $errors['linkedin_Validate'] = "linkedin url not valid";
    }
    
    #Validate address
    if(empty($address)){
        $errors['address']  = "address Required";
    }elseif(strlen($address) != 10){
        $errors['address_Validate']  = "Length must be = 10 chs ";
     }
    
    #Validate Password
    if(empty($password)){
        $errors['password']  = "password Required";
    }elseif(strlen($password) < 6){
       $errors['Password']  = "Password Length must be >= 6 chs ";
    }

    #Validate image
    if(empty($file_name)){
        $errors['fileToUpload'] = "image Required";
    }elseif(!in_array($file_extension,$extension_allow)){
        $errors['fileExtension'] = "not allowed file";
    }

    if(empty($file_name)){
        $errors['fileToUpload'] = "image Required";
    }
    else{
        if(in_array($file_extension,$extension_allow)){

            $desPath = 'uploads/'.$FinalName;
     
             if(move_uploaded_file($file_tmp_path,$desPath)){
                 echo 'Image Uploaded';
             }else{
                 echo 'Error In Uploading file';
             }
     
     
         }
         else{
             $errors['fileExtension'] = "not allowed file";
         }

    }
    


    if(empty($errors)){
        $_SESSION['name']=$name;
        $_SESSION['email']=$email;
        $_SESSION['linkedin']= $linkedin;
        $_SESSION['password']=$password;
        $_SESSION['address']=$address;
        $_SESSION['desPath']=$desPath;

        header("Location: profile.php");
    }else{
    
        foreach($errors as $key => $value){
            echo($key.":".$value);
            echo("<br>");
        }
    }
    
 }
?>

<!DOCTYPE HTML>
<html>  
<body>

<form action="<?php echo$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
Name: <input type="text" name="Name"><br>
E-mail: <input type="text" name="Email"><br>
linkedin: <input type="text" name="linkedin"><br>
address: <input type="text" name="address"><br>
Password: <input type="password" name="Password"><br>
file:<input type="file" name="fileToUpload"><br>
<input type="submit">
</form>
</body>
</html>
