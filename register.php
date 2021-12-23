<?php
include("helpers.php");
include('dbconnection.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = [];
    $user_name    = $_POST['user_name'];
    $role_id = 3;
    $name  = $_POST['name'];
    $email  = $_POST['email'];
    $password  = $_POST['password'];
    $phone  = $_POST['phone'];
    $address  = $_POST['address'];

    $file_name =   $_FILES['fileToUpload']['name'];
    $file_type   =   $_FILES['fileToUpload']['type'];
    $file_tmp_path = $_FILES['fileToUpload']['tmp_name'];
    $file_name_arr = explode(".", $file_name);
    $file_extension = end($file_name_arr);

    $user_name = clean($user_name);
    $name = clean($name);
    $email = clean($email);
    $phone = clean($phone);
    $address = clean($address);

    if (!validate($user_name, 1)) {
        $errors['user_name'] = "user_name Required";
    } elseif (!validate($user_name, 6)) {
        $errors['user_name'] = "user_name must be unique";
    }
    if (!validate($name, 1)) {
        $errors['name'] = "name Required";
    } elseif (!validate($name, 3)) {
        $errors['name'] = "name < 2";
    }

    if (!validate($email, 1)) {
        $errors['email'] = "email Required";
    } elseif (!validate($email, 2)) {
        $errors['email'] = "email not in form";
    }

    if (!validate($phone, 1)) {
        $errors['phone'] = "phone Required";
    } elseif (!validate($phone, 4)) {
        $errors['phone'] = "phone must be number";
    }

    if (!validate($address, 1)) {
        $errors['address'] = "address Required";
    }

    if (!validate($password, 1)) {
        $errors['password'] = "password Required";
    } elseif (!validate($password, 3)) {
        $errors['password'] = "password < 6";
    } else {
        $password = md5($password);
    }

    if (!validate($file_name, 1)) {
        $errors['fileToUpload'] = "image required";
    } elseif (!validate($file_extension, 5)) {
        $errors['fileToUpload'] = "file must be image";
    } else {
        $FinalName = rand() . time() . '.' . $file_extension;
        $desPath = 'uploads/' . $FinalName;

        if (move_uploaded_file($file_tmp_path, $desPath)) {
            echo 'Image Uploaded';
        } else {
            echo 'Error In Uploading file';
        }
    }

    if (empty($errors)) {
        $query = "INSERT INTO app_users (user_name ,role_id  ,name ,password,email,phone,address,File_Path)VALUES 
    ('$user_name', $role_id ,'$name','$password','$email',$phone,'$address','$desPath')";
        $op = mysqli_query($con, $query);
        if (!$op) {
            echo mysqli_error($con);
        }
        $message = 'delivery create';
        $_SESSION['Message'] = $message;
        $query ="select * from app_users where user_name='$user_name' and password ='$password'";
        $op= mysqli_query($con,$query);
        $_SESSION['client_data']=mysqli_fetch_assoc($op);
        header('Location:' . url('client/clientView.php'));
    }
}


include("layouts/header.php");
?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">
                                    <ol class="breadcrumb mb-4">
                                        <li class="breadcrumb-item active"><?php if (isset($errors)) {
                                                                                foreach ($errors as $key => $value) {
                                                                                    echo ($key . ":" . $value);
                                                                                    echo ("<br>");
                                                                                }
                                                                                unset($errors);
                                                                            }   ?></li>
                                    </ol>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputFirstName">User Name</label>
                                                    <input class="form-control py-4" id="inputFirstName" type="text" placeholder="Enter first name" name="user_name" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputLastName">Name</label>
                                                    <input class="form-control py-4" id="inputLastName" type="text" placeholder="Enter last name" name="name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputFirstName">Email</label>
                                                    <input class="form-control py-4" id="inputFirstName" type="email" placeholder="Enter first name" name="email" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputLastName">Address</label>
                                                    <input class="form-control py-4" id="inputLastName" type="text" placeholder="Enter last name" name="address" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputFirstName">phone</label>
                                                    <input class="form-control py-4" id="inputFirstName" type="number" placeholder="Enter first name" name="phone" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputLastName">Image</label>
                                                    <input class="form-control py-4" id="inputLastName" type="file" placeholder="Enter last name" name="fileToUpload" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputPassword">Password</label>
                                                    <input class="form-control py-4" id="inputPassword" type="password" placeholder="Enter password" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                                    <input class="form-control py-4" id="inputConfirmPassword" type="password" placeholder="Confirm password" name="password" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                                        </div>

                                    </form>
                                </div>
                                <div class="card-footer text-center">
                                    <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <?php
            include("layouts/footer.php")
            ?>