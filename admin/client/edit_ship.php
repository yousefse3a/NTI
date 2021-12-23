<?php
session_start();
include('../helpers.php');
include('../dbconnection.php');

if (!isset($_SESSION['client_data'])) {
    header("Location:" . url("login.php"));
} else {
    $client_data = $_SESSION['client_data'];
    $id = $_GET['id'];
    $assign_data = time();
    $query = "select * from shipment where id=$id";
    $op = mysqli_query($con, $query);
    $data = mysqli_fetch_assoc($op);
    $oldimg_path = $data['File_Path'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors = [];
        $client_id = $client_data['id'];
        $name    = $_POST['name'];
        $description    = $_POST['description'];
        $price  = $_POST['price'];
        $address_from  = $_POST['address_from'];
        $address_to  = $_POST['address_to'];
        $data_from  = $_POST['data_from'];
        $data_to  = $_POST['data_to'];
        $assign_data = time();
        $status_name = 'edited';

        $file_name =   $_FILES['fileToUpload']['name'];
        $file_type   =   $_FILES['fileToUpload']['type'];
        $file_tmp_path = $_FILES['fileToUpload']['tmp_name'];
        $file_name_arr = explode(".", $file_name);
        $file_extension = end($file_name_arr);

        $name = clean($name);
        $description = clean($description);
        $address_from = clean($address_from);
        $address_to = Clean($address_to);

        if (!validate($name, 1)) {
            $errors['description'] = "description Required";
        } elseif (!validate($name, 3)) {
            $errors['description'] = "description must be < 3";
        }
        if (!validate($description, 1)) {
            $errors['description'] = "description Required";
        } elseif (!validate($description, 3)) {
            $errors['description'] = "description must be < 3";
        }
        if (!validate($price, 1)) {
            $errors['name'] = "name Required";
        } elseif (!validate($price, 4)) {
            $errors['price'] = "price must number";
        }

        if (!validate($address_from, 1)) {
            $errors['email'] = "email Required";
        } elseif (!validate($address_from, 3)) {
            $errors['address_from'] = "address must details";
        }
        if (!validate($address_to, 1)) {
            $errors['email'] = "email Required";
        } elseif (!validate($address_to, 3)) {
            $errors['address_to'] = "address must details";
        }

        if (!validate($data_from, 1)) {
            $errors['phone'] = "phone Required";
        } elseif (!validate($data_from, 7)) {
            $errors['data_from'] = "date must be in from DD/MM/YYYY";
        } else {
            $data_from = strtotime($data_from);
        }
        if (!validate($data_to, 1)) {
            $errors['phone'] = "phone Required";
        } elseif (!validate($data_to, 7)) {
            $errors['data_to'] = "date must be in from DD/MM/YYYY";
        } else {
            $data_to = strtotime($data_to);
        }
        if (!validate($file_name, 1)) {
            $desPath = $oldimg_path;
        } elseif (!validate($file_extension, 5)) {
            $errors['fileToUpload'] = "file must be image";
        } else {
            $FinalName = rand() . time() . '.' . $file_extension;
            $desPath = '../uploads/' . $FinalName;

            if (move_uploaded_file($file_tmp_path, $desPath)) {
                echo 'Image Uploaded';
            } else {
                echo 'Error In Uploading file';
            }
        
        }
        if (empty($errors)) {


            $query = "update shipment set client_id = '$client_id', name = '$name',description='$description',price=$price
        ,address_from='$address_from',address_to='$address_to',data_from=$data_from,data_to=$data_to,assign_data=$assign_data
        ,File_Path ='$desPath' where id=$id";
            $op = mysqli_query($con, $query);
            if (!$op) {
                echo mysqli_error($con);
                exit();
            }
            $query = "INSERT INTO status (name,data,shipment_id) values('$status_name',$assign_data,$id)";
            $op = mysqli_query($con, $query);
            if (!$op) {
                echo mysqli_error($con);
                exit();
            }
            // $query = "UPDATE shipment set current_status=(select status.name from status where 
            // data=( select max(data) from status where shipment_id =$id)) WHERE shipment.id =$id";
            // $op   = mysqli_query($con, $query);
            $message = 'shipment edited';
            $_SESSION['Message'] = $message;
            header('Location:' . url('client/clientView.php'));
        }
   
    }
}
include('../layouts/header.php');
include('../layouts/nav.php');
include('../layouts/sidNav.php');
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h2>create shipment</h2>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><?php if (isset($errors)) {
                                                        foreach ($errors as $key => $value) {
                                                            echo ($key . ":" . $value);
                                                            echo ("<br>");
                                                        }
                                                        unset($errors);
                                                    } ?></li>
            </ol>
            <form action="<?php echo $_SERVER['PHP_SELF'].'?id='.$id; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control" id="exampleInputName" name="name" value="<?php echo $data['name']; ?>" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="exampleInputName">Description</label>
                    <input type="text" class="form-control" id="exampleInputName" name="description" value="<?php echo $data['description']; ?>" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="exampleInputName">Price</label>
                    <input type="number" class="form-control" id="exampleInputName" name="price" value="<?php echo $data['price']; ?>" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="exampleInputName">Address From</label>
                    <input type="text" class="form-control" id="exampleInputName" name="address_from" value="<?php echo $data['address_from']; ?>" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail">Address To</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="address_to" value="<?php echo $data['address_to']; ?>" placeholder="Enter content">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail">DataFrom</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="data_from" value="<?php echo date('m/d/y',$data['data_from']); ?>" placeholder="Enter content">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail">Data To</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="data_to" value="<?php echo date('m/d/y',$data['data_to']); ?>" placeholder="Enter content">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail">image</label>
                    <img src="<?php echo $data['File_Path']; ?>" height="200px" width="200px"><br>
                    <input type="file" name="fileToUpload"><br>
                </div>
                <button type="submit" class="btn btn-primary">edit shipment</button>
            </form>
        </div>
    </main>
    <?php
    include('../layouts/footer.php');
    ?>