<?php
include('../dbconnection.php');
include('../helpers.php');
session_start();
if (!isset($_SESSION['delivery_data'])) {
    header("Location:" . url("login.php"));
} else {
    $delivery_data = $_SESSION['delivery_data'];
    $id = $_GET['id'];
    $assign_data = time();
    $query = "INSERT INTO status (name,data,shipment_id) VALUES ('delivered',$assign_data,$id)";
    $op   = mysqli_query($con, $query);
    $query = "UPDATE shipment set current_status=(select status.name from status where 
    data=( select max(data) from status where shipment_id =$id)) WHERE shipment.id =$id;
    ";
    $op   = mysqli_query($con, $query);
    $message = 'shipment delivered';
    $_SESSION['Message'] = $message;
    header('Location:' . url('delivery/deliveryView.php'));
}
