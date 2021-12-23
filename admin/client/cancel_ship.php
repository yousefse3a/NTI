<?php
include('../dbconnection.php');
include('../helpers.php');
session_start();
if (!isset($_SESSION['client_data'])) {
    header("Location:" . url("login.php"));
} else {
    $client_data = $_SESSION['client_data'];
    $id = $_GET['id'];
    $assign_data = time();
    $query = "INSERT INTO status (name,data,shipment_id) VALUES ('canceled',$assign_data,$id)";
    $op   = mysqli_query($con, $query);
    $query = "UPDATE shipment set current_status=(select status.name from status where 
    data=( select max(data) from status where shipment_id =$id)) WHERE shipment.id =$id;
    ";
    $op   = mysqli_query($con, $query);
    $message = 'shipment canceled';
    $_SESSION['Message'] = $message;
    header('Location:' . url('client/clientView.php'));
}
