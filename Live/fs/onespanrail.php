<?php 
$w = 1000; // lb/ft
$a = 1394.4; // cantilever mm 
$b = 3657.6; //span mm
$c = 1394.4; // cantilever mm
$sum = $w + $a + $b + $c;  
$feet = 304.8;

$aft = $a /$feet;
$bft = $b / $feet;
$cft = $a / $feet;
 
$sumft = $sum / $feet;

$R1 = ($w * $sumft *($sumft - 2 * $cft )) / ( 2 * $bft);
$row = 50;

for($i = 0 ; $i <= $row ; $i++){
	
	echo ($bft / ($row)) * $i;
	
}
echo "<br>";
?>