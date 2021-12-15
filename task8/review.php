<?php
include('dbconnection.php');
include('helpers.php');
session_start();
if(!isset($_SESSION['data'])){
    header("Location: loginpage.php");
}else{
    $user_data=$_SESSION['data'];
    $x=$user_data['id'];
    $query = "select id,title,description,startdate,enddate,FilePath from todo_list where user_id = $x";
    $op  = mysqli_query($con,$query);
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <!-- custom css -->
    <style>
        .m-r-1em {
            margin-right: 1em;
        }
        .m-b-1em {
            margin-bottom: 1em;
        }

        .m-l-1em {
            margin-left: 1em;
        }

        .mt0 {
            margin-top: 0;
        }

    </style>
</head>

<body>

    <!-- container -->
    <div class="container">
        <div class="page-header">
            <h1>Review tasks </h1>
            <br>
            <?php 
            if(isset($_SESSION['Message'])){
                echo $_SESSION['Message'];
                unset($_SESSION['Message']);
            }        
        ?>
        <br>
        </div>
        <a href='createtask.php' class='btn btn-danger m-r-1em'>create</a>
        <a href='logout.php' class='btn btn-danger m-r-1em'>logout</a>
        <table class='table table-hover table-responsive table-bordered'>
            <!-- creating our table heading -->
            <tr>
                <th>ID</th>
                <th>title</th>
                <th>content</th>
                <th>image</th>
                <th>action</th>
            </tr>

<?php 

while($data = mysqli_fetch_assoc($op)){
?>
    <tr>
       <td><?php echo $data['id'];?></td>
       <td><?php echo $data['title'];?></td>
       <td><?php echo $data['description'];?></td>
       <td><?php echo $data['startdate'];?></td>
       <td><?php echo $data['enddate'];?></td>
       <td><img src="<?php echo $data['FilePath'];?>" height="100px" width="100px"></td>
                <td>
                    <a href='delete.php?id=<?php echo $data['id'];?>' class='btn btn-danger m-r-1em'>Delete</a>
                    <a href='edit.php?id=<?php echo $data['id'];?>' class='btn btn-primary m-r-1em'>Edit</a>

                </td>
            </tr>
<?php 
}
?>
            <!-- end table -->
        </table>
    </div>
    <!-- end .container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- confirm delete record will be here -->

</body>

</html>