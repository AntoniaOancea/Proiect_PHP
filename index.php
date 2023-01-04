<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<h1 class="jumbotron text-center">Welcome!</h1>
	
	<?php include('header.php')?>
	<?php 
		include('functions.php');
		$select=mysqli_fetch_assoc(mysqli_query($conn,"select count(*) as ct from orders"));
		if($select["ct"]){
	?>
		<div class="diagram">
		<?php include('diagrama.php')?>
		</div> 
	<?php }?>
	<div class="parse">
		<?php include('parse.php')?>
	</div>
<br><br>
  <p>Autor: Oancea Elena-Antonia<br>
  <?php include('proiect.html')?></p>
<style>
footer {
    clear: both;
    position: relative;
    height: 200px;
    margin-top: -200px;
}
.parse{
	display:flex;
	padding:100px;
}
</style>	
	
</body>
</html>