<?php
include('helper.php');
include('blog.php');

$db_obj = new DBclass;
$help_obj = new helper;
$op=$db_obj->dbquery("select * from blog");

include('layouts/header.php');
include('layouts/nav.php');
include('layouts/sidNav.php');
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">blog View</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><?php if (isset($_SESSION['Message'])) {
                                                        echo $_SESSION['Message'];
                                                        unset($_SESSION['Message']);
                                                    }     ?></li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href='<?php echo $help_obj->url("create.php"); ?>' class='btn btn-success float-right m-r-1em'>create</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>title</th>
                                    <th>content</th>
                                    <th>Image</th>
                                    <th>edite</th>
                                    <th>delete</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>title</th>
                                    <th>content</th>
                                    <th>Image</th>
                                    <th>edite</th>
                                    <th>delete</th>


                                </tr>
                            </tfoot>
                            <tbody>

                                <?php
                                if(is_bool($op)){

                                }
                                else{while ($data = mysqli_fetch_assoc($op)) {
                                ?>
                                    <tr>
                                        <td><?php echo $data['title']; ?></td>
                                        <td><?php echo $data['content']; ?></td>
                                        <td><img src="<?php echo $data['File_Path']; ?>" height="100px" width="100px"></td>
                                        <td><a href="<?php echo $help_obj->url('view.php') . '?id=' . $data['id']; ?>" class='btn btn-success float-right m-r-1em'>edit</a></td>
                                        <td><a href="<?php echo $help_obj->url('delete.php') . '?id=' . $data['id']; ?>" class='btn btn-success float-right m-r-1em'>delete</a></td>
                                    </tr>
                                <?php
                                }}
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php
    include('layouts/footer.php');
    ?>