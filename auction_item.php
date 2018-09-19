<?php
    session_start();
    require 'connection.php';
    if(!isset($_SESSION['username'])){
        header('location: login.php');
    }
    $item_id=$_GET['id'];
    $check_out=0;
    $stock_info=1;
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    //get increment and bid_end_time
    $get_auctionitem_query="select increment, bid_end_time from auctionitem where item_id='$item_id'";
    $get_auctionitem_result=mysqli_query($con,$get_auctionitem_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($get_auctionitem_result);
    $increment=$row['increment'];
    $bid_end_time=$row['bid_end_time'];
    //get bid item current price
    $get_price_query="select price from item where item_id='$item_id'";
    $get_price_result=mysqli_query($con,$get_price_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($get_price_result);
    $current_price=$row['price'];
    //get the current winner of the bid item
    $get_current_winner_query="select winner_uid from auctionitem where item_id='$item_id'";
    $get_current_winner_result=mysqli_query($con,$get_current_winner_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($get_current_winner_result);
    $current_winner=$row['winner_uid'];
    //get stock information
    $get_stock_query="select stock_info from normalitem where item_id='$item_id'";
    $get_stock_result=mysqli_query($con,$get_stock_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($get_stock_result);
    if($row['stock_info']==0){
      $stock_info=0;
    }
    $check_out==0;
    //update winned table
    $current_date =  date('Y-m-d H:i:s');
    if ($current_winner!=0){
    
      if(strtotime($current_date)>strtotime($bid_end_time)){
        $check_winned_query="select * from winned where item_id='$item_id' and uid = '$current_winner'";
        $check_winned_result=mysqli_query($con,$check_winned_query) or die(mysqli_error($con));
        if(mysqli_num_rows($check_winned_result)==0){
          $update_winned_query="INSERT into winned(item_id,uid) values('$item_id','$current_winner')";
          $update_winned_result=mysqli_query($con,$update_winned_query) or die(mysqli_error($con));
          } 
        $check_out=1;
        
      }
    }
    //get item name and discription
    $get_item_name_query="SELECT item_name, description from item where item_id='$item_id'";
    $get_item_name_result=mysqli_query($con,$get_item_name_query) or die(mysqli_error($con));
    $row=mysqli_fetch_array($get_item_name_result);
    $item_name=$row['item_name'];
    $description=$row['description'];
?>
<!DOCTYPE html>
<html>
    <head>
        
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
        <link href="css/shop-item.css" rel="stylesheet">
    </head>
    <body>

    <!-- Navigation -->
    <?php
                require 'header.php';
            ?>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

       
        <!-- /.col-lg-3 -->

        <div class="col-lg-12">

          <div class="card mt-4">
            <img class="card-img-top img-fluid" width="900" height=auto src='img/<?php echo $item_id?>.jpg' alt="">
            <div class="card-body">
              <h3 class="card-title"><?php echo $item_name;?></h3>
              <h4>$<?php echo $current_price;?></h4>
              <p class="card-text"><?php echo $description;?></p>
              
            </div>
          </div>
          <br><br>

          <div class="card card-outline-secondary my-4">
            <div class="card-header">
              add $ <?php echo $increment; ?> every time
            </div>
            <br>
            <div class="card-body">
              <?php if($current_winner!=$user_id &&strtotime($current_date)<strtotime($bid_end_time)){ ?>
              <a href="auction_add.php?id=<?php echo $item_id; ?>" class="btn btn-success" name="add" value="add" >Bid now!</a>
              <?php }elseif($current_winner==$user_id && $check_out==0){ ?>
                <a href="#" class="btn btn-success disabled">You are the highest</a>
                <?php }elseif(strtotime($current_date)>strtotime($bid_end_time)&& $check_out==0){ ?>
                  <a href="#" class="btn btn-success disabled">Bid ends</a>
                <?php } elseif($check_out==1 && $current_winner==$user_id && $stock_info==1){?>
                  <a href="checkout_auction.php?id=<?php echo $item_id; ?>" class="btn btn-success" name="add" value="add" >Winned! Now Check Out</a>
                <?php }elseif($check_out==1 && $current_winner==$user_id && $stock_info==0){?>
                <a href="#" class="btn btn-success disabled" name="add" value="add" >You get the item</a> 
                <?php }?>          
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col-lg-9 -->

      </div>

    </div>
    <br><br><br><br><br><br>
    <br><br><br><br><br><br>
    <!-- /.container -->

    <!-- Footer -->
    <?php
                    require 'footer.php';
                ?>

  </body>
</html>
