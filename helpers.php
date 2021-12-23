<?php 
function validate($input,$flag){
    $status = true;
   switch ($flag) {
       case 1:
             if(empty($input)){
                 $status = false;
             }
           break;
       
       case 2: 
       if(!filter_var($input,FILTER_VALIDATE_EMAIL)){
           $status = false;
       }
       break;


       case 3:
       if(strlen($input) < 6){
           $status = false; 
       }
       break;
 

       case 4: 
       if(!filter_var($input,FILTER_VALIDATE_INT)){
           $status = false;
       }
       break;

      case 5: 
      $allowedExtension = ['png','jpg','PNG','JPG'];
      if(!in_array($input,$allowedExtension)){
          $status = false;
      }
      break;

      case 6:
        include('dbconnection.php');
       $query="select * from app_users where user_name = '$input'";
       $op= mysqli_query($con,$query);
       if(!$op){
           echo mysqli_error($con);
       }else{
           if(mysqli_num_rows($op) > 0){
               $status = false;
           }
       }
       break;

       case 7:
           $date = date_parse($input); // or date_parse_from_format("d/m/Y", $date);
           if (!checkdate($date['month'], $date['day'], $date['year'])) {
               $status = false;
           }
        break;

        
 
   }

   return $status ; 
}
function url($url){

    return   "http://".$_SERVER['HTTP_HOST']."/onspeed/".$url;
   
}

function Clean($input){

    return   strip_tags(trim($input));
}
// function xx(){
//     echo '<link rel="stylesheet" href="../css/all.min.css">
//     <link rel="stylesheet" href="../css/bootstrap.min.css">
//     <link rel="stylesheet" href="../css/style.css">
//     <script src="../js/popper.min.js"></script>
//     <script src="../js/bootstrap.min.js"></script>';
// }

?>