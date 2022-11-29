<?php include 'controllers.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
  <title>User verification system PHP - Login</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Lora');
li { list-style-type: none; }
.form-wrapper {
  margin: 50px auto 50px;
  font-family: 'Lora', serif;
  font-size: 1.09em;
}
.form-wrapper.login { margin-top: 120px; }
.form-wrapper p { font-size: .8em; text-align: center; }
.form-control:focus { box-shadow: none; }
.form-wrapper {
  border: 1px solid #80CED7;
  border-radius: 5px;
  padding: 25px 15px 0px 15px;
}
.form-wrapper.auth .form-title { color: #007EA7; }
.home-wrapper button,
.form-wrapper.auth button {
  background: #007EA7;
  color: white;
}
.home-wrapper {
  margin-top: 150px;
  border-radius: 5px;
  padding: 10px;
  border: 1px solid #80CED7;
}
</style>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 offset-md-4 form-wrapper auth login">
        <h3 class="text-center form-title">Login</h3>
<?php if (count($errors) > 0): ?>
  <div class="alert alert-danger">
    <?php foreach ($errors as $error): ?>
    <li>
      <?php echo $error; ?>
    </li>
    <?php endforeach;?>
  </div>
<?php endif;?>
        <form action="login.php" method="post">
            
          <div class="form-group">
            <label>Username or Email</label>
            <input type="text" name="username" class="form-control form-control-lg" value="<?php $username; ?>">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control form-control-lg">
          </div>
          <div class="form-group">
            <button type="submit" name="login-btn" class="btn btn-lg btn-block">Login</button>
          </div>
        </form>
        <p>Don't yet have an account? <a href="signup.php">Sign up</a></p>
      </div>
    </div>
  </div>
</body>
</html>
