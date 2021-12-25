<?php
session_start();
include('helper.php');
include('blog.php');
$help_obj=new helper;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title    = $_POST['title'];
        $content    = $_POST['content'];
    
        $file_name =   $_FILES['fileToUpload']['name'];
        $file_tmp_path = $_FILES['fileToUpload']['tmp_name'];
        $file_extension = $help_obj->fileExtenison($file_name);

        $title = $help_obj->clean($title);
        $content = $help_obj->clean($content);
        

        if (!($help_obj->validate($title, 1))) {
            $errors['title'] = "title Required";
        } elseif (!$help_obj->validate($title, 3)) {
            $errors['title'] = "title must be < 3";
        }
        if (!$help_obj->validate($content, 1)) {
            $errors['content'] = "content Required";
        } elseif (!$help_obj->validate($content, 3)) {
            $errors['content'] = "content must be < 3";
        }
        
        if (!$help_obj->validate($file_name, 1)) {
            $errors['fileToUpload'] = "image required";
        } elseif (!$help_obj->validate($file_extension, 5)) {
            $errors['fileToUpload'] = "file must be image";
        } else {
            $desPath=$help_obj->add_img($file_name,$file_tmp_path);
        }
        if (empty($errors)) {
            $blog_obj= new blog($title,$content,$desPath);
            $blog_obj->create_blog();
            $message = 'blog create';
            $_SESSION['Message'] = $message;
            header('Location:' . $help_obj->url('index.php'));
        }
    }

include('layouts/header.php');
include('layouts/nav.php');
include('layouts/sidNav.php');
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h2>create </h2>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><?php if (isset($errors)) {
                                                        foreach ($errors as $key => $value) {
                                                            echo ($key . ":" . $value);
                                                            echo ("<br>");
                                                        }
                                                        unset($errors);
                                                    } ?></li>
            </ol>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control" id="exampleInputName" name="title" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="exampleInputName">Description</label>
                    <input type="text" class="form-control" id="exampleInputName" name="content" placeholder="Enter title">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail">image</label>
                    <input type="file" name="fileToUpload"><br>
                </div>
                <button type="submit" class="btn btn-primary">create </button>
            </form>
        </div>
    </main>
    <?php
    include('layouts/footer.php');
    ?>