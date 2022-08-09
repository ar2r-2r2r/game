<?php  
$array=$_POST['array'];
$basicArray=array(0,1,2,3,4,5,6,7,8);
$diff=array_diff($basicArray, $array);
$answer=array_rand($diff,1);
echo $answer;
