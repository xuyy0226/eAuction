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
                            <th>Order Number</th><th>price</th><th>Order Date</th><th>Review Order</th>
                        </tr>
                       <?php 
                        $user_products_query="select *  from purorder where uid = '$user_id'";
                        $user_products_result=mysqli_query($con,$user_products_query) or die(mysqli_error($con));
                        $counter=1;
                        while($row=mysqli_fetch_array($user_products_result)){    
                         ?>
                        <tr>
                            <th><?php echo $counter ?></th>
                            <th><?php echo $row['total_price'] ?></th>
                            <th><?php echo $row['today_date'] ?></th>
                            <th><a href='review_order.php?order_id=<?php echo $row['order_id'] ?>'>Review Order</a></th>
                        </tr>
                       <?php $counter=$counter+1;}?>
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
