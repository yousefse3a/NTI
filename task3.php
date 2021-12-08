<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $name   = $_POST['Name'];
    $email  = $_POST['Email'];
    $linkedin = $_POST['linkedin'];
    $password = $_POST['Password'];
    $address  = $_POST['address'];

$errors=[];
# Validate Name ... 
if(empty($name)){
    $errors['Name']  = "Field Required";
}
# Validate Email ..... 
if(empty($email)){
    $errors['Email'] = "Field Required";
}
# Validate linkedin ..... 
if(empty($linkedin)){
    $errors['linkedin'] = "Field Required";
}

#Validate address
if(strlen($address) != 10){
    $errors['address']  = "Length must be = 10 chs ";
 }

#Validate Password
if(strlen($password) < 6){
   $errors['Password']  = "Password Length must be >= 6 chs ";
}
if(empty($errors)){
    echo"done";
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

<form action="<?php echo$_SERVER['PHP_SELF'];?>" method="post">
Name: <input type="text" name="Name"><br>
E-mail: <input type="text" name="Email"><br>
linkedin: <input type="text" name="linkedin"><br>
address: <input type="text" name="address"><br>
Password: <input type="password" name="Password"><br>
<input type="submit">
</form>

</body>
</html>