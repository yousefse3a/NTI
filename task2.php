<?php
function next_char($x){
 
$char = $x;
$nextchar = ++$char; 
 
if (strlen($nextchar) > 1) 
{
 $nextchar = $nextchar[0];
 }
echo $nextchar."\n";
}
next_char('z');

?>