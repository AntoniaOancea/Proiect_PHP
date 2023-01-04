<?php

require 'header.php';
require 'functions.php';
check_login();
if($_SESSION['USER']->id!=5)
   header('Location:shop.php');

if(isset($_POST['add_product'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_stock = $_POST['product_stock'];
   $product_image = $_FILES['product_image']['name'];
   $product_image_tmp_name = $_FILES['product_image']['tmp_name'];
   $product_image_folder = 'uploaded_img/'.$product_image;

   if(empty($product_name) || empty($product_price) || empty($product_image) || empty($product_stock)){
      $message[] = 'please fill out all';
   }else{
      $insert = "INSERT INTO products(name, price , stock, image) VALUES('$product_name', '$product_price', '$product_stock','$product_image')";
      $upload = mysqli_query($conn,$insert);
      if($upload){
         move_uploaded_file($product_image_tmp_name, $product_image_folder);
         $message[] = 'new product added successfully';
      }else{
         $message[] = 'could not add the product';
      }
   }

};

if(isset($_GET['delete'])){
   $id = $_GET['delete'];
   database_run("DELETE FROM products WHERE id = $id");
   header('location:admin_page.php');
};

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <title>admin page</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <link rel="stylesheet" href="style.css">

</head>
<body>
<h1 class="jumbotron text-center">Admin</h1>

<?php

if(isset($message)){
   foreach($message as $message){
      echo '<span class="message">'.$message.'</span>';
   }
}

?>
<a href="generate_pdf.php" class="btn btn-danger" target="_">Generate PDF<a> 
<div class="container">

   <div class="admin-product-form-container">

      <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
         <h3>add a new product</h3>
         <input type="text" placeholder="enter product name" name="product_name" class="box">
         <input type="number" placeholder="enter product price" name="product_price" class="box">
         <input type="number" placeholder="enter the stock of the product" name="product_stock" class="box">
         <input type="file" accept="image/png, image/jpeg, image/jpg" name="product_image" class="box">
         <input type="submit" class="btn" name="add_product" value="add product">
      </form>

   </div>

   <?php
$select = mysqli_query($conn, "SELECT * FROM products");
   
?>
<div class="product-display">
   <table class="product-display-table">
      <thead>
      <tr>
         <th>product image</th>
         <th>product name</th>
         <th>product price</th>
         <th>product stock</th>
         <th>action</th>
      </tr>
      </thead>
      <?php while($row = mysqli_fetch_assoc($select)){ ?>
      <tr>
         <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100px" alt=""></td>
         <td><?php echo $row['name']; ?></td>
         <td>$<?php echo $row['price']; ?>/-</td>
         <td><?php echo $row['stock']; ?></td>
         <td>
            <a href="admin_update.php?edit=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-edit"></i> edit </a>
            <a href="admin_page.php?delete=<?php echo $row['id']; ?>" class="btn"> <i class="fas fa-trash"></i> delete </a>
         </td>
      </tr>
   <?php } ?>
   </table>
</div>

</div>


</body>
</html>