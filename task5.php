<?php

$jsonData =   file_get_contents("http://shopping.marwaradwan.org/api/Products/1/1/0/100/atoz");
$dataArray = json_decode($jsonData,true);
$file =  fopen("product.txt","w")  or die("Can't open File");


for ($i = 0; $i < count($dataArray["data"]); $i++) {
    $text="products_id ".($i+1).":".$dataArray["data"][$i]["products_id"]."\n";
    $text=$text."products_name".($i+1).":".$dataArray["data"][$i]["products_name"]."\n";
    $text=$text."products_description".($i+1).":".$dataArray["data"][$i]["products_description"]."\n";
    $text=$text."products_quantity ".($i+1).":".$dataArray["data"][$i]["products_quantity"]."\n";
    $text=$text."products_model".($i+1).":".$dataArray["data"][$i]["products_model"]."\n";
    $text=$text."products_date_added ".($i+1).":".$dataArray["data"][$i]["products_date_added"]."\n";
    $text=$text."products_liked".($i+1).":".$dataArray["data"][$i]["products_liked"]."\n";
    $text=$text."products_image".($i+1).":".$dataArray["data"][$i]["products_image"]."\n";
    
      $text=$text."<hr>"."<hr>"."<hr>"."\n";
      fwrite($file,$text);
  }
  fclose($file);
$file =  fopen("product.txt","r")  or die("Can't open File");
while(!feof($file) ){
     echo  fgets($file).'<br>';
}

fclose($file);
?>
