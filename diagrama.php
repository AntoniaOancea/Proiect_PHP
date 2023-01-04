<?php
//require 'includes/dbh.inc.php'; //conexiunea la baza de date
$conn = new mysqli("localhost","root","antonia","magazin");
require 'jpgraph/src/jpgraph.php';
require 'jpgraph/src/jpgraph_bar.php';

$sql = "SELECT product, sum(quantity) as comandate from orders GROUP by product";
$result = $conn->query($sql);
$num_results = $result->num_rows;
$products = array();
$quantity = array();
for ($i=0; $i <$num_results; $i++) {
   $row = $result->fetch_assoc();
   array_push($products,$row["product"].' ');
   array_push($quantity,intval($row["comandate"]));
   echo '<div>'.$i.'.'.$row["product"]."   ".'<div>';}

$fimg ='jpgraph-3d_pie.png';

//$data =[40,60,25,34];

$graph = new Graph(960,660);

//$theme_class= new VividTheme;
$graph->SetScale('intlin');
$graph->SetShadow();

$graph->title->SetFont(FF_FONT1,FS_BOLD);


$graph->legend->Pos(.088,0.9);

$bplot=new BarPlot($quantity);
//$bplot->SetLegends($quantity);
$graph->Add($bplot);
$graph->Stroke($fimg);

if(file_exists($fimg)) echo '<img width=500px weight=500px src="'. $fimg .'" />';
else echo 'Unable to create: '. $fimg;
