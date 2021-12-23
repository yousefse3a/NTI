<?php
session_start();
include('../helpers.php');
include('../dbconnection.php');
if (!isset($_SESSION['delivery_data'])) {
    header("Location:" . url("login.php"));
} else {
    $delivery_data = $_SESSION['delivery_data'];
    $delivery_id = $delivery_data['id'];
    $query = "select * from shipment where delivery_id = $delivery_id  and current_status='assign delivery'";
    $op = mysqli_query($con, $query);
    if (!$op) {
        echo mysqli_error($con);
    }
    $query = "select * from shipment where delivery_id = $delivery_id  and current_status='on delivery'";
    $op2 = mysqli_query($con, $query);
    if (!$op2) {
        echo mysqli_error($con);
    }
    $query = "select * from shipment where delivery_id = $delivery_id  and current_status='delivered'";
    $op3 = mysqli_query($con, $query);
    if (!$op3) {
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
                    Assign recent
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>

                                <?php
                                while ($data = mysqli_fetch_assoc($op)) {
                                ?>
                                    <tr>
                                        <td><a href="<?php echo url('client/track_ship.php') . '?id=' . $data['id']; ?>"><?php echo $data['name']; ?></a></td>
                                        <td><?php echo $data['description']; ?></td>
                                        <td><?php echo $data['current_status']; ?></td>
                                        <td><img src="<?php echo $data['File_Path']; ?>" height="100px" width="100px"></td>
                                        <td> <a href='<?php echo url('delivery/accept_ship.php') . '?id=' . $data['id']; ?>' class='btn btn-success float-right m-r-1em'>accept</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    On delivery
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            <tbody>

                                <?php
                                while ($data = mysqli_fetch_assoc($op2)) {
                                ?>
                                    <tr>
                                        <td><a href="<?php echo url('client/track_ship.php') . '?id=' . $data['id']; ?>"><?php echo $data['name']; ?></a></td>
                                        <td><?php echo $data['description']; ?></td>
                                        <td><?php echo $data['current_status']; ?></td>
                                        <td><img src="<?php echo $data['File_Path']; ?>" height="100px" width="100px"></td>
                                        <td> <a href='<?php echo url('delivery/delivered.php') . '?id=' . $data['id']; ?>' class='btn btn-success float-right m-r-1em'>delieverd</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    Delivered
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
                                while ($data = mysqli_fetch_assoc($op3)) {
                                ?>
                                    <tr>
                                        <td><a href="<?php echo url('client/track_ship.php') . '?id=' . $data['id']; ?>"><?php echo $data['name']; ?></a></td>
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