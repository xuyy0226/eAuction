<?php
    session_start();
    require 'connection.php';
    if(!isset($_SESSION['username'])){
        header('location: login.php');
    }
    if($_SESSION['has_checkout']!=1){
        header('location: auction_item.php');
    }
    //get user id
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    //get address id
    $address_id=$_GET['id'];
    //get item_id
    $item_id=$_GET['item_id'];
    //get quantity and total price of user
    $price_query="select price from item where item_id='$item_id'";
    $price_result=mysqli_query($con,$price_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($price_result);
    $su=$row["price"];
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
            <div class="col-lg-12">    
              <h4><b>Product Name</b></h4>
                <hr/>
                <div>
                    <center>  
                    <h4>Success - your order is confirmed!</h4>
                    <h5>Order number: #<?php echo $track_num;?></h5>
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
                                        
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    <tr><?php 
                                        $user_products_query="select * from item where item_id='$item_id'";
                                        $user_products_result=mysqli_query($con,$user_products_query) or die(mysqli_error($con)); 
                                        $row= mysqli_fetch_assoc($user_products_result);
                                        ?>
                                        <td><?php echo $row['item_name']?></td>
                                        <td class="text-right"><?php echo 1;?></td>
                                        <td class="text-right"><?php echo $row['price']?></td>
                    
                                    </tr>
                                    
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
        <?php $_SESSION['has_checkout']=0;?>
        </div>
        <footer class="footer"> 
               <div class="container">
               <center>
                   <p>Copyright &copy Eauction. All Rights Reserved.</p>
                   <p>This website is developed by A Squad</p>
               </center>
               </div>
           </footer>
        </div> <!-- /container -->

      </body>
</html>
