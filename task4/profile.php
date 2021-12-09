<?php

session_start();

if(isset($_SESSION['name']) && isset($_SESSION['email']) && isset($_SESSION['linkedin'])
&& isset($_SESSION['password']) && isset($_SESSION['address']) && isset($_SESSION['desPath'])){
    echo  $_SESSION['name'].'<br>';
    echo  $_SESSION['linkedin'].'<br>';
    echo  $_SESSION['email'].'<br>';
    echo  $_SESSION['password'].'<br>';
    echo  $_SESSION['address'].'<br>';
    echo  $_SESSION['desPath'].'<br>';

    
    
}       
else{
       echo 'Session of Name  &&  Email Deleted <br>';
}


?>
<html>
<img src ="<?php echo  $_SESSION['desPath']; ?>" width="400px" />
</html>
