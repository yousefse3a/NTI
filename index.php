<?php
$ele_units=51;
$bill=0;
$unit_cost_first = 3.50;
$unit_cost_second = 4.00; 
$unit_cost_above = 6.50;


if($ele_units<=50){
    $bill=$ele_units*$unit_cost_first;
}
elseif($ele_units>50 && $ele_units<=100){
   $bill=(50*$unit_cost_first)+(($ele_units-50)*$unit_cost_second);
}
else{
    $bill=(50*$unit_cost_first)+(100*$unit_cost_second)+(($ele_units-150)*$unit_cost_above);
}
echo($bill);

?>