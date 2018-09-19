<?php
    session_start();
    require 'connection.php';
    if(!isset($_SESSION['username'])){
        header('location: login.php');
    }
    if($_SESSION['has_checkout']!=1){
        header('location: checkout.php');
    }
    //get user id
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    //get address id
    $address_id=$_GET['id'];
    
    $user_products_query="select distinct(it.item_name), h.quantity, (it.price*d.discount) as price, i.item_id from include i, hascart h, users u, item it, discount d where h.uid=u.uid and i.cart_id = h.cart_id and u.uid = '$user_id' and it.item_id= i.item_id and d.is_company=u.is_company and h.order_id=0";
    $user_products_result=mysqli_query($con,$user_products_query) or die(mysqli_error($con));
    //get quantity and total price of user
    $price_query="select (h.total_price*d.discount) as total_price from hascart h, users u, discount d where h.uid = '$user_id' and u.uid ='$user_id' and d.is_company=u.is_company and h.order_id=0 limit 1";
    $price_result=mysqli_query($con,$price_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($price_result);
    $su=$row["total_price"];
    //get order id
    $select_max_order_query="SELECT max(order_id) FROM purorder where uid='$user_id'";
    $select_max_order_result=mysqli_query($con,$select_max_order_query) or die(mysqli_error($con));
    $row=mysqli_fetch_assoc($select_max_order_result);
    $order_id=$row['max(order_id)'];

    $get_track_num_query="SELECT track_num from trackpackage where order_id='$order_id'";
    $get_track_num_result=mysqli_query($con,$get_track_num_query) or die(mysqli_error($con));
    $row=mysqli_fetch_assoc($get_track_num_result);
    $track_num=$row['track_num'];

    //get ship price
    $get_ship_price_query="select s.ship_price from shipprice s, (SELECT ship_time FROM purorder WHERE order_id='$order_id') as temp where temp.ship_time = s.ship_time";
    $get_ship_price_result=mysqli_query($con,$get_ship_price_query) or die(mysqli_error($con));
    $row=mysqli_fetch_assoc($get_ship_price_result);
    $ship_price=$row['ship_price'];

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>Eauction</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- latest compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!-- External CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">
        <link href="css/jumbotron-narrow.css" rel="stylesheet">
        
    </head>
    <?php
        require 'header.php';
        ?>
    <body class="main">
        
        <div class="container">
          <div class="row marketing"> 
            <div class="col-lg-12 col-md-12 col-sm-12">    
              <h4><b>Product Name</b></h4>
                <hr/>
                <div>
                    <center>  
                    <h4>Success - your order is confirmed!</h4>
                    <h5>Track number: #<?php echo $track_num;?></h5>
                    <h5>Carrier: USPS</h5>
                    <hr />  
                </div>
                </center>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                    <div class="col-xs-6">
                        <address>
                        <?php 
                        $get_address_query = "select * from address where uid='$user_id' and address_id='$address_id'";
                        $get_address_result=mysqli_query($con,$get_address_query) or die(mysqli_error($con));
                        $row=mysqli_fetch_array($get_address_result);
                        $zipcode=$row["zipcode"];
                        ?>
                        <strong>Shipping Address:</strong><br>
                            <?php echo $row["firstname"];echo ' ';echo $row["lastname"];?><br>
                            <?php echo $row["phone"];?><br>
                            <?php echo $row["addressline_1"];echo ' ';echo $row["addressline_2"];?><br>
                            <?php echo $zipcode;echo ' ';
                            $zipcode_query = "select * from address2 where zipcode = '$zipcode'";
                            $zipcode_result = mysqli_query($con,$zipcode_query) or die(mysqli_error($con));
                            $row= mysqli_fetch_assoc($zipcode_result);
                            echo $row["city"];;echo ' ';echo $row["state"];?>
                        </address>

                    </div>
                    <div class="col-xs-6 text-right">
                    <h1><span class="glyphicon glyphicon glyphicon-cloud-download" aria-hidden="true"></span></h1>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center><p><span class="glyphicon glyphicon glyphicon-question-sign" aria-hidden="true"></span> 
                        You will received your package within <?php $ship_time?> days, Thank you</p> </center>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <td><strong>Product Name</strong></td>
                                        <td class="text-right"><strong>Quantity of item</strong></td>
                                        <td class="text-right"><strong>Item per Price</strong></td>
                                        <td class="text-right"><strong>Comments</strong></td>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    <tr><?php 
                                        $user_products_result=mysqli_query($con,$user_products_query) or die(mysqli_error($con));
                                        $num_item=mysqli_num_rows($user_products_result);
                                        while($row=mysqli_fetch_array($user_products_result)){
                                        $item_id=$row['item_id'];
                                        $review_id=rand(1,100000000);
                                        $insert_containreview_query="INSERT into containreview(review_id,item_id,order_id) values('$review_id','$item_id','$order_id')";
                                        $insert_containreview_result=mysqli_query($con,$insert_containreview_query) or die(mysqli_error($con));
                                        ?>
                                        <td><?php echo $row['item_name']?></td>
                                        <td class="text-right"><?php echo $row['quantity']?></td>
                                        <td class="text-right"><?php echo $row['price']?></td>
                                        <td class="text-right"><a href='product_comment.php?order_id=<?php echo $order_id; ?>
                                        '>Review My order</td>
                                        </tr>
                                        <?php }?>
                                    
                                    <?php 
                                        $update_hascart_query="UPDATE hascart h, include i SET h.order_id='$order_id' WHERE i.Cart_id=h.cart_id and h.uid = '$user_id' and h.order_id=0";
                                        $update_hascart_result=mysqli_query($con,$update_hascart_query) or die(mysqli_error($con));
                                        //$delete_hascart_query="DELETE FROM hascart  WHERE uid = '$user_id'";
                                        //$delete_hascart_result=mysqli_query($con,$delete_hascart_query) or die(mysqli_error($con));
                                        ?>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-right"><strong>Shipping</strong></td>
                                        <td class="no-line text-right"><?php echo $ship_price;?></td>
                                    </tr>
                                    <tr>
                                        <td class="no-line"></td>
                                        <td class="no-line"></td>
                                        <td class="no-line text-right"><strong>Total</strong></td>
                                        <td class="no-line text-right"><?php echo $su;?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="index.php" class="btn btn-block btn-primary" >Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $_SESSION['has_checkout']=0;
        $_SESSION['add_comment']=1;?>
        </div>
        
        </div> <!-- /container -->
<?php
                require 'footer.php';
            ?>
      </body>
</html>
