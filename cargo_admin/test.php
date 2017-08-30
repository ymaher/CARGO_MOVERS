<?php
$f = '$@@`!';
$filter = substr($f,0,strpos($f,"$"));
$filterfield = substr($f,(strpos($f,"$")+1),(strpos($f,"@@")-strpos($f,"$")-1));
$wholeonly = substr($f,strpos($f,"@@")+2,(strpos($f,"`")-strpos($f,"@@")-2));
$todate = substr($f,strpos($f,"`")+1,(strpos($f,"!")-strpos($f,"`")-1));
$fromdate = substr($f,strpos($f,"!")+1,(strlen($f)-strpos($f,"!")-1));

echo "F = ".$f."<br />";
echo "Filter = ".$filter."<br/>";
echo "Filterfield = ".$filterfield."<br/>";
echo "Wholeonly = ".$wholeonly."<br/>";
echo "Todate = ".$todate."<br/>";
echo "Fromdate = ".$fromdate."<br/>";

$f = $filter."$".$filterfield."@@".$wholeonly."`".$todate."!".$fromdate;
echo "Reformated f = ".$f."<br />";

echo "<br /><br />New techinique<br />";
$f = $filter."`".$filterfield."`".$wholeonly."`".$todate."`".$fromdate;

$param = explode("`",$f);

$filter = $param[0];
$filterfield = $param[1];
$wholeonly = $param[2];
$todate = $param[3];
$fromdate = $param[4];

echo "F = ".$f."<br />";
echo "Filter = ".$filter."<br/>";
echo "Filterfield = ".$filterfield."<br/>";
echo "Wholeonly = ".$wholeonly."<br/>";
echo "Todate = ".$todate."<br/>";
echo "Fromdate = ".$fromdate."<br/>";

$f = $filter."`".$filterfield."`".$wholeonly."`".$todate."`".$fromdate;
echo "Reformated f = ".$f."<br />";

?>