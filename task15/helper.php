<?php

class helper
{

    function Clean($input)
    {

        return   strip_tags(trim($input));
    }
    function url($url)
    {

        return   "http://" . $_SERVER['HTTP_HOST'] . "/task15/" . $url;
    }

    function validate($input, $flag)
    {
        $status = true;
        switch ($flag) {
            case 1:
                if (empty($input)) {
                    $status = false;
                }
                break;

            case 2:
                if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                    $status = false;
                }
                break;


            case 3:
                if (strlen($input) < 6) {
                    $status = false;
                }
                break;


            case 4:
                if (!filter_var($input, FILTER_VALIDATE_INT)) {
                    $status = false;
                }
                break;

            case 5:
                $allowedExtension = ['png', 'jpg', 'PNG', 'JPG'];
                if (!in_array($input, $allowedExtension)) {
                    $status = false;
                }
                break;

        }

        return $status;
    }
    function fileExtenison($file_name){
        $file_name_arr = explode(".", $file_name);
        $file_extension = end($file_name_arr);
        return $file_extension ;
    }
    function add_img($file_name,$file_tmp_path){
        $file_extension = $this->fileExtenison($file_name);
        $FinalName = rand() . time() . '.' . $file_extension;
        $desPath = 'uploads/' . $FinalName;
        if (move_uploaded_file($file_tmp_path, $desPath)) {
            echo 'Image Uploaded';
        } else {
            echo 'Error In Uploading file';
        }
        return $desPath;
    }
  
}
