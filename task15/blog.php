<?php
include('dbconnect.php');

class blog{
    private $title;
    private $content;
    private $File_Path;
    private $db_obj;
 
    function __construct($title,$content,$File_Path)
    {
        $this->title=$title;
        $this->content=$content;
        $this->File_Path=$File_Path;
        $this->db_obj=new DBclass;

    }

    function create_blog(){
        $query="insert into blog (title,content,File_Path)values('$this->title','$this->content','$this->File_Path')";
        return $this->db_obj-> dbquery($query);
    }

    function delete_blog($id)
    {
        $query="delete from blog where id=$id";
        return $this->db_obj-> dbquery($query);
    }
    function update_blog($obj)
    {
        $query="update blog set 'title'='$obj->title' , 'content'='$obj->content','File_Path'='$obj->File_Path'";
        
        return $this->db_obj-> dbquery($query);
    }
    function read_blog($id)
    {
        $query="select * from blog where = $id";
        $date=mysqli_fetch_assoc($this->db_obj-> dbquery($query));
        return $date;
    }
}


?>