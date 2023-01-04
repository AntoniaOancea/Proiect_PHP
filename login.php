<?php  

require "functions.php";

$errors = array();

if($_SERVER['REQUEST_METHOD'] == "POST")
{
	$errors = login($_POST);

	if(count($errors) == 0)
	{
		header("Location: shop.php");
		die;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<body>
	<h1 class="jumbotron text-center">Login</h1>

	<?php include('header.php')?>

	<section class="vh-100 gradient-custom">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-8 col-lg-6 col-xl-5">
					<div class="card bg-dark text-white" style="border-radius: 1rem;">
						<div class="card-body p-5 text-center">
							<div class="mb-md-5 mt-md-4 pb-5">
								<h2 class="fw-bold mb-2 text-uppercase">Login</h2>
								<p class="text-white-50 mb-5">Please enter your login and password!</p>
								<div>
									<div>
										<?php if(count($errors) > 0):?>
											<?php foreach ($errors as $error):?>
												<?= $error?> 
											<?php endforeach;?>
										<?php endif;?>

									</div>
								</div>
								<form method="post" >
									<div class="form-outline form-white mb-4">
										<input type="email" name="email" placeholder="Email" class="form-control form-control-lg">
										<label class="form-label" for="typeEmailX-2">Email</label>
									</div>
									<div class="form-outline form-white mb-4">
										<input type="password" name="password" placeholder="Password" class="form-control form-control-lg">
										<label class="form-label" for="typePasswordX-2">Password</label>
									</div>
									<input type="submit" value="Login"  class="btn btn-primary btn-block mb-4">
								</form>


							</div>
        				</div>
      				</div>
    			</div>
 			</div>
		</div>
	</section>	
</body>
</html>
