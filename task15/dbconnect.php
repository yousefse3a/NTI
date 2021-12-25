<?php

class DBclass
{
    private $server = "localhost";
    private $dbUser = "root";
    private $dbPassword = "";
    private $dbName = "task15";
    var $con = null;

    function __construct()
    {
        $this->con = mysqli_connect($this->server, $this->dbUser, $this->dbPassword, $this->dbName);

        if(!$this->con){
            echo 'Errror : '.mysqli_connect_error();
        }
  
    }
    function dbquery($query)
    {
        $op=mysqli_query($this->con,$query);
        return $op;
    }

    function __destruct(){
        mysqli_close($this->con);
    }
}
