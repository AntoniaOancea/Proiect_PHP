<?php
	require "functions.php";
     require "mail.php";
     require "recaptchalib.php";
	check_login();
	
	if(isset($_POST["add_to_cart"]))  
 {  
     $id=$_GET["id"];
     $st = mysqli_query($conn,"select stock from products where id='$id'");
     $stock = mysqli_fetch_array($st);
     if($stock['stock']==0)
          echo '<script>alert("Item is not longer available")</script>';
     else
          if($stock['stock']<$_POST["quantity"])
               echo '<script>alert("Not enough products in stock")</script>';
     else
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
           if(!in_array($_GET["id"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
                     'item_id'               =>     $_GET["id"],  
                     'item_name'               =>     $_POST["hidden_name"],  
                     'item_price'          =>     $_POST["hidden_price"],  
                     'item_quantity'          =>     $_POST["quantity"] 
                );  
                $_SESSION["shopping_cart"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Added")</script>';  
                echo '<script>window.location="shop.php"</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
                'item_id'               =>     $_GET["id"],  
                'item_name'               =>     $_POST["hidden_name"],  
                'item_price'          =>     $_POST["hidden_price"],  
                'item_quantity'          =>     $_POST["quantity"]  ,
           );  
           $_SESSION["shopping_cart"][0] = $item_array;  
      }  
     
 }  
 if(isset($_GET["action"]))  
 {  
      if($_GET["action"] == "delete")  
      {  
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
                if($values["item_id"] == $_GET["id"])  
                {  
                     unset($_SESSION["shopping_cart"][$keys]);  
                     echo '<script>alert("Item Removed")</script>';  
                     echo '<script>window.location="shop.php"</script>';  
                }  
           }  
      }  
 } 
 if(isset($_POST["order"]))
 {
     if(empty($_SESSION["shopping_cart"]))
          echo '<script>alert("Add at least one product to the shopping cart before")</script>';
     else
     {
          $ok=1;
          foreach($_SESSION["shopping_cart"] as $keys => $values) 
          {
               $id=$values["item_id"];
               $st = mysqli_query($conn,"select stock from products where id='$id'");
               $stock = mysqli_fetch_array($st); 
               if($values["item_quantity"]>$stock["stock"])
                   {
                    $ok=0;
                    unset($_SESSION["shopping_cart"][$keys]);
                    echo '<script>alert("One item is not longer available")</script>'; 
                   }
               
          }
          if($ok==1)
          {
               $recipient = $_SESSION['USER']->email;
               $nb_order =  rand(1,99999999);
               $html='<!DOCTYPE html>
               <html lang="en">
               <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>PDF</title>
               </head>
               <style>
                    h2{
                         font-family:Verdana, Geneva, Tahoma, sans-serif;
                         text-align:center;
                    }
                    table{
                         font-family: Arial, Helvetica, sans-serif;
                         border-collapse:collapse;
                         width:100%;
                    }
                    td,th{
                         border: 1px solid #444;
                         padding:8px;
                         text-align:left;
                    }
               
               </style>
               <body>
                    <div> 
                         User: '.$recipient.'
                         Order : '.$nb_order.'
                    <div>
                    <table>
                         <thead>
                              <tr>
                                   <th>ID</th>
                                   <th>Item</th>
                                   <th>Price</th>
                                   <th>Quantity</th>
                              </tr>
                         </thead>
                         <tbody>';
              
               $i=1;
               foreach($_SESSION["shopping_cart"] as $keys => $values) 
               {
                    $id=$values["item_id"];
                    $name=$values["item_name"];
                    $q=$values["item_quantity"];
                    $price=$values["item_price"]*$q;
                    $user=$_SESSION['USER']->email;
                    $st = mysqli_query($conn,"select stock from products where id='$id'");
                    $stock = mysqli_fetch_array($st); 
                    $insert="insert into orders(nb_order,product,quantity,price,user) values ('$nb_order','$name','$q','$price*$q','$user')";
                    $update="update products set stock=stock-'$q' where name='$name'";
                    mysqli_query($conn,$insert);
                    mysqli_query($conn,$update);
                    unset($_SESSION["shopping_cart"][$keys]);
                    $html.='<tr>
                    <td>'.$i.'</td>
                    <td>'.$name.'</td>
                    <td>'.$price.'</td>
                    <td>'.$q.'</td>
                    </tr>';
                    $i++;
               } 
               echo '<script>alert("Order sent")</script>'; 
               $subject = "Order confirmation";
               
               require_once 'vendor/autoload.php';

               
          }
          $html.=' </tbody>
               </table>
               </body>
               </html>';
         // echo $html;
          send_mail($recipient,$subject,$html);
     }
 } 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Shop</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>

	<h1 class="jumbotron text-center">Shop</h1>

	<?php include('header.php');?>
	<p>&nbsp;
	<?php if(check_login(false)):?>
		Hello, <?=strtoupper($_SESSION['USER']->username)?>!

		<br><br>
		<?php if(!check_verified()):?>
			<a href="verify.php">
			<button class="col-sm-1">Verify Profile</button>
			</a>
			<?php else: ?>
			<?php if($_SESSION['USER']->id==5):?>
				<a href="admin_page.php"> <button class="col-sm-1">Admin Page</button> </a> 
			<?php endif; ?>
			<?php  
                $query = "SELECT * FROM products ORDER BY id ASC";  
                $result = mysqli_query($conn, $query);  
                if(mysqli_num_rows($result) > 0)  
                {  
                     while($row = mysqli_fetch_array($result))  
                     {  
                ?>  
						<div class="col-md-4">  
							<form method="post" action="shop.php?action=add&id=<?php echo $row["id"]; ?>">  
								<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:10px; padding:5px;" align="center">  
									<img style="width:300px;height:200px;" src="<?php echo "uploaded_img/".$row["image"]; ?>" class="img-responsive" /><br />  
									<h4 class="text-info"><?php echo $row["name"]; ?></h4>  
									<h4 class="text-danger">$ <?php echo $row["price"]; ?></h4>  
									<input type="text" name="quantity" class="form-control" value="1" />  
									<input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />  
									<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />  
									<input type="submit" name="add_to_cart" style="margin-top:1px;" class="btn btn-success" value="Add to Cart" />  
								</div>  
							</form>  
						</div>  
                <?php  
                     }  
                }  
            ?>  
		<?php endif; ?>
		<div style="clear:both"></div>  
                <br />  
                <h3>Order Details</h3>  
                <div class="table-responsive" method="post">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="40%">Item Name</th>  
                               <th width="10%">Quantity</th>  
                               <th width="20%">Price</th>  
                               <th width="15%">Total</th>  
                               <th width="5%">Action</th>  
                          </tr>  
                          <?php   
                          if(!empty($_SESSION["shopping_cart"]))  
                          {  
                               $total = 0;  
                               foreach($_SESSION["shopping_cart"] as $keys => $values)  
                               {  
                          ?>  
                          <tr>  
                               <td><?php echo $values["item_name"]; ?></td>  
                               <td><?php echo $values["item_quantity"]; ?></td>  
                               <td>$ <?php echo $values["item_price"]; ?></td>  
                               <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>  
                               <td><a href="shop.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
                          </tr>  
                          <?php  
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);  
                               }  
                          ?>  
                          <tr>  
                               <td colspan="3" align="right">Total</td>  
                               <td align="right">$ <?php echo number_format($total, 2); ?></td>  
                               <td></td>  
                          </tr>  
                          <?php  
                          }  
                          ?> 
                          <form method="post" action="shop.php?action=order&id=<?php echo $_SESSION['USER']->id?>">
                          <div class="g-recaptcha"  data-sitekey="6Lf0dscjAAAAAMKe2C7OL05DRNmjDsRIQXt6mnHN" button="onclick"></div>
                         <br/>
                         <?php
                              $secretKey  = '6Lf0dscjAAAAAAMs74i_bwilmdp2TehjjH5-olPN'; 
                              if(!empty($_POST['g-recaptcha-response'])){
                              
                              $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']); 
                              $responseData = json_decode($verifyResponse); 
                              if($responseData->success){
                              
                         ?>
                          <?php }}?>
                          <input type="submit" name="order" style="margin-top:1px;" class="btn btn-success" value="order" />  
                         
                         </form>
                     </table> 
                </div>  
                    
           </div>  
           <br /> 

	<?php endif; ?>

</body>
</html>
