<?php
    session_start();
    require 'connection.php';
    if(!isset($_SESSION['username'])){
        header('location: login.php');
    }

    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    //get shipping date and price
    $shipping_query="select * from shipprice";
    //get the item id that is added to cart
    $user_products_query="select distinct(it.item_name),it.item_id, h.quantity, (it.price*d.discount) as price from include i, hascart h, users u, item it, discount d where h.uid=u.uid and i.cart_id = h.cart_id and u.uid = '$user_id' and it.item_id= i.item_id and d.is_company=u.is_company and h.order_id=0";
    $user_products_result=mysqli_query($con,$user_products_query) or die(mysqli_error($con));
    //get quantity and total price of user
    $price_query="select (h.total_price*d.discount) as total_price from hascart h, users u, discount d where h.uid = '$user_id' and u.uid ='$user_id' and d.is_company=u.is_company and h.order_id = 0 limit 1";
    $price_result=mysqli_query($con,$price_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($price_result);
    $rows_fetched=mysqli_num_rows($user_products_result);
    if($rows_fetched==0){
        echo '<script type="text/javascript">'; 
        echo 'alert("There is nothing in your cart!");'; 
        echo 'window.location.href = "index.php";';
        echo '</script>';

    }else{
        $su=$row["total_price"];
    }
?>
<!DOCTYPE html>
<html>
    <head>
       
        <title>Eauction</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- latests compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- External CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <div>
            <?php 
               require 'header.php';
            ?>
            <br>
            <div class="container">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>Item Number</th><th>Item Name</th><th>Quantity of item</th><th>Item per Price</th><th></th>
                        </tr>
                       <?php 
                        $user_products_result=mysqli_query($con,$user_products_query) or die(mysqli_error($con));
                        $counter=1;
                        while($row=mysqli_fetch_array($user_products_result)){ 
                            $item_id=$row['item_id'];   
                         ?>
                        <tr>
                            <th><?php echo $counter ?></th>
                            <th><a href="product.php?id=<?php echo $item_id;?>"><?php echo $row['item_name']?></a></th>
                            <th><?php echo $row['quantity']?></th>
                            <th><?php echo $row['price']?></th>
                            <th><a href='cart_remove.php?item_id=<?php echo $item_id ?>'>Remove</a></th>
                        </tr>
                       <?php $counter=$counter+1;}?>
                        <tr>
                            <th></th><th>Total</th><th> <?php echo $su;?></th><th><a href="checkout.php" class="btn btn-primary">Check Out</a></th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br><br><br><br>
            <?php
                require 'footer.php';
            ?>
        </div>
    </body>
</html>
