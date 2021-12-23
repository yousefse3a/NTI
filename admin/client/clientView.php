<?php
session_start();
include('../helpers.php');
include('../dbconnection.php');
if (!isset($_SESSION['client_data'])) {
    header("Location:" . url("login.php"));
} else {
    $client_data = $_SESSION['client_data'];
    $client_id = $client_data['id'];
    $query = "select * from shipment where client_id= $client_id";
    $op = mysqli_query($con, $query);
    if (!$op) {
        echo mysqli_error($con);
    }
}

include('layouts/header.php');
include('layouts/nav.php');
include('layouts/sidNav.php');
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Shipment View</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><?php if (isset($_SESSION['Message'])) {
                                                        echo $_SESSION['Message'];
                                                        unset($_SESSION['Message']);
                                                    }     ?></li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <a href='<?php echo url("client/add_ship.php"); ?>' class='btn btn-success float-right m-r-1em'>create</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                <?php
                                while ($data = mysqli_fetch_assoc($op)) {
                                    // $x = $data['id'];
                                    // $query = "select status.name from status where 
                                    // data=( select max(data) from status where shipment_id =$x)";
                                    // $op2 = mysqli_query($con, $query);
                                    // if (mysqli_num_rows($op2) == 1) {
                                    //     $current_status = mysqli_fetch_assoc($op2);
                                    // } else {
                                    //     echo 'not find status';
                                    // }
                                ?>
                                    <tr>
                                        <td><a href="<?php echo url('client/track_ship.php').'?id='.$data['id'];?>"><?php echo $data['name']; ?></a></td>
                                        <td><?php echo $data['description']; ?></td>
                                        <td><?php echo $data['current_status']; ?></td>
                                        <td><img src="<?php echo $data['File_Path']; ?>" height="100px" width="100px"></td>
                                    </tr>
                                <?php
                                }
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