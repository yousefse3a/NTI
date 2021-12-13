<?php
function x (){
    include('DBconnect.php');
    $query = 'select id from blog';
    $op = mysqli_query($con,$query);
    $ids=[];
    while($data = mysqli_fetch_assoc($op)){
       array_push($ids,$data['id']);
    }
return $ids;
}

// function del_img($id){
//     include('DBconnect.php');
//     $query = "select FilePath from blog where id = $id";
//     $op  = mysqli_query($con,$query);
//     $data = mysqli_fetch_assoc($op);
//     $file_path=$data['FilePath'];
//     unlink($file_path);
// }

function clean($field){
    return strip_tags($field);
}

function validate($field,$flag){
    $status=true;
    switch($flag){
        case 1:
            if(empty($field)){
                $status =false;
            }
            break;
        case 2:
            if(strlen($field)<6){
                $status=false;
            }
            break;
        case 3:
            if(strlen($field)<30){
                $status=false;
            }
            break;
        case 4:
            $ids=x();
            if(!in_array($field,$ids)){
                $status=false;
            }
            break;
        }
    return $status;
}

function is_img($field){
    $status=true;
    $extension_allow=['png','jpg','PNG','JPG'];
    if(!in_array($field,$extension_allow)){
        $status =false;
    }
    return $status;
}



?>
