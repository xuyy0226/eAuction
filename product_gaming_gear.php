<?php
    session_start();
    require 'connection.php';
    //get user id
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
        <!-- latest compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="eauction.js"></script>
        <!-- External CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">

    </head>
    <body>
        <div>
            <?php
                require 'header.php';
            ?>
            <div class="container">
                <div class="row">
                    <?php
                        require 'search.php';
                    ?>

                    <div class="col-md-9 col-sm-9">
                    <h2>Browser History</h2>
                    </div>
                    <?php $count=0;
                    $get_browser_query="SELECT b.item_id, i.item_name from browse b, item i where i.item_id=b.item_id and uid='$user_id' ORDER BY b.timestamp DESC";
                    $get_browser_result=mysqli_query($con,$get_browser_query) or die(mysqli_error($con));
                    $row = mysqli_fetch_array($get_browser_result);
                    while($count<3 && $row = mysqli_fetch_array($get_browser_result)){?>
                    <div class="col-md-3 col-sm-4">
                        <?php 
                        $item_name=$row['item_name'];
                        $item_id=$row['item_id'];?>
                        <div class="thumbnail">
                            <a href="product.php?id=<?php echo $item_id;?> " alt="<?php echo $item_name;?>">
                            <img src="img/<?php echo $item_id;?>.jpg" alt="">  
                            </a>
                        </div>
                        <?php echo $item_name;
                        $count = $count+1;?>
                    </div>
                    <?php }?>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-3 col-sm-4">
                        
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <h3>Category</h3>
                        <div class="thumbnail">
                            <img src="img/mouse.jpg" alt="">
                            <center>
                                <div class="caption">
                                    <h3>Mouse</h3>
                                    <p><a href="category.php?type_id=1" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <br><br><br>
                        <div class="thumbnail">
                            <img src="img/keyboard.jpg" alt="">
                            <center>
                                <div class="caption">
                                    <div class="caption">
                                        <h3>Keyboard</h3>
                                        <p><a href="category.php?type_id=2" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <br><br><br>
                        <div class="thumbnail">
                            <img src="img/hardware.jpg" alt="">
                            <center>
                                <div class="caption">
                                    <h3>Hardware</h3>
                                    <p><a href="category.php?type_id=3" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    
                                </div>
                            </center>
                        </div>
                    </div>
                </div>    
            </div>
            <br><br><br><br><br><br><br><br>
           <?php
                require 'footer.php';
            ?>
        </div>
    </body>
</html>
