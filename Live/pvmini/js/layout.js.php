<?php
header("Content-Type: text/javascript");
$path = "../";
require_once($path."includes/class.Image.php");
$img = new Image(IMG_WIDTH, false);
echo "var inch=".$img->inch.";\n";

echo "var maxXOffset=".$img->getMaxHorizOffset().";\n";
echo "var maxYOffset=".($img->getMaxVertOffset()).";\n";
echo "var total_rows=".$_SESSION[S_PREFIX."rows"].";\n";
echo "var total_cols=".$_SESSION[S_PREFIX."cols"].";\n\n";

$bld = $img->getBuildingSize();
echo "var roofWidth=".$bld["w"].";\n";
echo "var roofHeight=".$bld["h"].";\n";
echo "var roofWidthFT=".$_SESSION[S_PREFIX."building_length"].";\n";
echo "var roofHeightFT=".Calculator::getTrueRoofSize().";\n";

$zones = $img->getZones(true);
if($_SESSION[S_PREFIX."orientation"] == LANDSCAPE)
{
   $arrayX = $_SESSION[S_PREFIX."module_length"];
   $arrayY = $_SESSION[S_PREFIX."module_width"];
}
else
{
   $arrayX = $_SESSION[S_PREFIX."module_width"];
   $arrayY = $_SESSION[S_PREFIX."module_length"];
}

$arrayX = ($arrayX * $_SESSION[S_PREFIX."cols"]);
$arrayX = Calculator::in2ft(Calculator::mm2in($arrayX));

$arrayY = ($arrayY * $_SESSION[S_PREFIX."rows"]);
$arrayY = Calculator::in2ft(Calculator::mm2in($arrayY));

echo "var arrayWidth=".(Calculator::ft2in($arrayX) * $img->inch).";\n";
echo "var arrayHeight=".(Calculator::ft2in($arrayY) * $img->inch).";\n\n";

echo "var arrayWidthFT=".$arrayX.";\n";
echo "var arrayHeightFT=".$arrayY.";\n";

echo "\nvar leftZoneX1=".$zones["nw_corner"]["w"].";\n";
echo "\nvar leftZoneX2=".$zones["w_exterior"]["w"].";\n";

$rightZoneX1 = $zones["nw_corner"]["w"] + $zones["n_exterior"]["w"];
$rightZoneX1 -= $arrayX;
echo "var rightZoneX1=".$rightZoneX1.";\n";

$rightZoneX2 = $zones["w_exterior"]["w"] + $zones["interior"]["w"];
$rightZoneX2 -= $arrayX;
echo "var rightZoneX2=".$rightZoneX2.";\n";

echo "var topZoneY=".$zones["nw_corner"]["h"].";\n";

$bottomZoneY = $zones["nw_corner"]["h"] + $zones["w_exterior"]["h"];
$bottomZoneY -= $arrayY;

echo "var bottomZoneY=".$bottomZoneY.";\n";

echo "var gridSize=".round($_SESSION[S_PREFIX."spacing"] * $img->inch).";\n";

$layout = Calculator::getLayout();
echo "var layout= new Array(".implode(",", $layout).");\n";

require_once("__layout__.js");
?>
