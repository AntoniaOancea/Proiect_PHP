<?php  

require "functions.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{

	$errors = signup($_POST);

	if(count($errors) == 0)
	{
		header("Location: login.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Signup</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<h1 class="jumbotron text-center">SignUp</h1>

	<?php include('header.php')?>

	<section class="text-center text-lg-start">
	<style>
		.cascading-right {
		margin-right: -50px;
		}

		@media (max-width: 991.98px) {
		.cascading-right {
			margin-right: 0;
		}
		}
	</style>

	<div class="container py-4">
		<div class="row g-0 align-items-center">
			<div class="col-lg-6 mb-5 mb-lg-0">
				<div class="card cascading-right" style="background: hsla(0, 0%, 100%, 0.55);backdrop-filter: blur(30px);">
					<div class="card-body p-5 shadow-5 text-center">
						<h2 class="fw-bold mb-5">Sign up now</h2>
						<div>
							<?php if(count($errors) > 0):?>
								<?php foreach ($errors as $error):?>
									<?= $error?> <br>	
								<?php endforeach;?>
							<?php endif;?>

						</div>
						<form method="POST">
							<div class="form-outline mb-4">
								<input type="text" name="username" id="form3Example1" class="form-control" />
								<label class="form-label" for="form3Example1">Username</label>
							</div>

							<div class="form-outline mb-4">
								<input type="email" name="email" id="form3Example2" class="form-control" />
								<label class="form-label" for="form3Example2">Email address</label>
							</div>

							<div class="form-outline mb-4">
								<input type="password" name="password" id="form3Example3" class="form-control" />
								<label class="form-label" for="form3Example3">Password</label>
							</div>

							<div class="form-outline mb-4">
								<input type="password" name="password2" id="form3Example4" class="form-control" />
								<label class="form-label" for="form3Example4">Retype Password</label>
							</div>
							
							<button type="submit" class="btn btn-primary btn-block mb-4">Sign up
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
</body>
</html>