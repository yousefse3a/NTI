<?php
include('../dbconnection.php');
include('../helpers.php');
session_start();
if (!isset($_SESSION['client_data'])) {
    header("Location:" . url("login.php"));
} else {
    $client_data = $_SESSION['client_data'];
    $id = $_GET['id'];
    $query = "select * from shipment where shipment.id = $id";
    $op   = mysqli_query($con, $query);
    if (mysqli_num_rows($op) == 1) {
        $data = mysqli_fetch_assoc($op);
        $delivery_id = $data['delivery_id'];
    }
    if ($delivery_id != null) {
        $query = "select name from app_users where id = $delivery_id ";
        $op = mysqli_query($con, $query);
        $delivery_data = mysqli_fetch_assoc($op);
        $delivery_name = $delivery_data['name'];
    }
    else{
        $delivery_name = 'not assign yet!!';
    }


    $query = "select name ,data from status where shipment_id = $id";
    $op = mysqli_query($con, $query);
}
include('layouts/header.php');
include('layouts/nav.php');
include('layouts/sidNav.php');
?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h1 class="mt-4"><?php echo $data['name']; ?> View</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><?php if (isset($_SESSION['Message'])) {
                                                        echo $_SESSION['Message'];
                                                        unset($_SESSION['Message']);
                                                    }     ?></li>
            </ol>
            <div class="card mb-4">
                <div class="card-header">
                    <?php echo $data['name']; ?> View
                    <a href='<?php echo url('client/edit_ship.php') . '?id=' . $data['id']; ?>' class='btn btn-success float-right m-r-1em'>edit</a>
                    <a href='<?php echo url('client/cancel_ship.php') . '?id=' . $data['id']; ?>' class='btn btn-success float-right m-r-1em'>cancel</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>price</th>
                                    <th>address_from</th>
                                    <th>address_to</th>
                                    <th>data_from</th>
                                    <th>data_to</th>
                                    <th>assign_data</th>
                                    <th>delivery name</th>
                                    <th>status</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['description']; ?></td>
                                    <td><?php echo $data['price']; ?></td>
                                    <td><?php echo $data['address_from']; ?></td>
                                    <td><?php echo $data['address_to']; ?></td>
                                    <td><?php echo date('m/d/Y', $data['data_from']); ?></td>
                                    <td><?php echo date('m/d/Y ', $data['data_to']); ?></td>
                                    <td><?php echo date('m/d/Y H:i:s', $data['assign_data']); ?></td>
                                    <td><?php echo $delivery_name; ?></td>
                                    <td><?php
                                        while ($status_data = mysqli_fetch_assoc($op)) {
                                            if ($status_data['name'] != 'edited') {
                                                echo $status_data['name'] . '<br>' . date('m/d/Y H:i:s', $status_data['data']) . '<hr>';
                                            }
                                        } ?></td>
                                    <td><img src="<?php echo $data['File_Path']; ?>" height="100px" width="100px"></td>
                                </tr>
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