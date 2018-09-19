<?php
    session_start();
    require 'connection.php';
    $item_id=$_GET['id'];
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    $check_browse_query="select * from browse where item_id='$item_id' and uid='$user_id'";
    $check_browse_result=mysqli_query($con,$check_browse_query) or die(mysqli_error($con));
    $rows_fetched=mysqli_num_rows($check_browse_result);
    if($rows_fetched==0){
        $insert_browse_query="INSERT INTO browse(item_id,uid) VALUES($item_id,$user_id)";
        $insert_browse_result=mysqli_query($con,$insert_browse_query) or die(mysqli_error($con));
    }
    //get item name and discription
    $get_item_name_query="SELECT item_name, description, price from item where item_id='$item_id'";
    $get_item_name_result=mysqli_query($con,$get_item_name_query) or die(mysqli_error($con));
    $row=mysqli_fetch_array($get_item_name_result);
    $item_name=$row['item_name'];
    $description=$row['description'];
    $price=$row['price'];
    //get product review and star
    $get_review_query="SELECT c.stars, c.content,u.username from containreview c, purorder p, users u where item_id = '$item_id' and u.uid=p.uid and p.order_id=c.order_id";
    $get_review_result=mysqli_query($con,$get_review_query) or die(mysqli_error($con));
    $sponsor_id=rand(1,5);
    $get_sponsor_link_query="select sponsor_link from sponsor where sponsor_id='$sponsor_id'";
    $get_sponsor_link_result=mysqli_query($con,$get_sponsor_link_query) or die(mysqli_error($con));
    $row=mysqli_fetch_array($get_sponsor_link_result);
    $sponsor_link=$row['sponsor_link'];

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
        <link href="css/shop-item.css" rel="stylesheet">
    </head>
    <body>

    <!-- Navigation -->
    <?php
                require 'header.php';
            ?>

    <!-- Page Content -->
    <div class="container" style="margin:50;padding:0">
      <div class="row">
      <div class="content">
        <div class="col-lg-3 col-md-3 col-sm-4">
          <h3 class="card-title">Sponsor</h3>
          <iframe width="300" height="200" src='<?php echo $sponsor_link ?>' allowfullscreen></iframe>
          <h3 class="card-title">Guess You may also like</h3>
          <?php $id=rand(1,27);

          if ($id == $item_id){
            $id==rand(1,27);}
            $get_guess_item_name_query="SELECT item_name from item where item_id='$id'";
            $get_guess_item_name_result=mysqli_query($con,$get_guess_item_name_query) or die(mysqli_error($con));
            $row=mysqli_fetch_array($get_guess_item_name_result);
            $guess_item_name=$row['item_name'];
        ?>
        <img width="250" height=auto class="card-img-top img-fluid" src='img/<?php echo $id; ?>.jpg' alt="">
        <a href="product.php?id=<?php echo $id;?>">
        <h5><?php echo $guess_item_name;?> </h5>
        </a>
        </div>
        
        <!-- /.col-lg-3 -->
   
        <div class="col-lg-9">

          <div class="card mt-4" style="padding:20">
            <img width="500" height=auto class="card-img-top img-fluid" src='img/<?php echo $item_id ?>.jpg' alt="">
            <div class="card-body">
              <h3 class="card-title"><?php echo $item_name;?></h3>
              <h4>$<?php echo $price;?></h4>
              <p class="card-text"><?php echo $description;?></p>
              
            </div>
          </div>
          <!-- /.card -->

          <div class="card card-outline-secondary my-4" style="padding:20">
            <div class="card-header">
             <h4> Product Reviews</h4>
            </div>
            <br><br>
            <?php 
            while ($row=mysqli_fetch_array($get_review_result)){
              $content=$row['content'];
              $stars=$row['stars'];
              $username=$row['username'];
              $total_stars=$stars?>
            <div class="card-body">
              <span class="text-warning"><?php $count=0; while ($stars>0){ 
                $stars = $stars-1;
                $count=$count+1;?>&#9733; <?php } while($count<5){
                  $count=$count+1;?>  &#9734; <?php }?></span>
              <?php echo $total_stars;?>/5
              <p><?php echo $content;?></p>
              <small class="text-muted">Posted by <?php echo $username;?></small>
              <hr>
              <?php } ?>
              <?php if(!isset($_SESSION['username'])){  ?>
                <p><a href="login.php" role="button" class="btn btn-success">Buy Now</a></p>
                <?php
                }
                else{
                        ?>
                        <a href="cart_add.php?id=<?php echo $item_id; ?>" class="btn btn-success" name="add" value="add" >Add to cart</a>
                        <?php
                }
                ?>           
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col-lg-9 -->
      </div>
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
