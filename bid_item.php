<?php
	require 'connection.php';
	session_start();
	if(!isset($_SESSION['username'])){
        header('location: login.php');
    }
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    $check_company_query="SELECT is_company from users where uid='$user_id'";
    $check_company_result=mysqli_query($con,$check_company_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($check_company_result);
    $is_company=$row["is_company"];
    if($is_company==1){
    echo '<script type="text/javascript">'; 
    echo 'alert("company cannot bid!");'; 
    echo 'window.location.href = "index.php";';
    echo '</script>';
    }   
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
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <div>
            <?php
                require 'header.php';
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail">
                            <img src="img/100.jpg" alt="">
                            <center>
                                <div class="caption">
                                    <h3>crown of courage</h3>
                                    <p><a href="auction_item.php?id=<?php echo '100'; ?>" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail">
                            <img src="img/101.jpg" alt="">
                            <center>
                                <div class="caption">
                                    <div class="caption">
                                        <h3>felflame inferno shoulderpads</h3>
                                        <p><a href="auction_item.php?id=<?php echo '101'; ?>" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail">
                                <img src="img/102.jpg" alt="">
                            <center>
                                <div class="caption">
                                    <h3>red winter clothes</h3>
                                    <p><a href="auction_item.php?id=<?php echo '102'; ?>" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
                <br><br><br><br><br><br><br><br>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail">
                            <a href="cart.php">
                                <img src="img/103.jpg" alt="">
                            </a>
                            <center>
                                <div class="caption">
                                    <h3>vestment of summer</h3>
                                    <p><a href="auction_item.php?id=<?php echo '103'; ?>" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail">
                            <a href="cart.php">
                                <img src="img/104.jpg" alt="">
                            </a>
                            <center>
                                <div class="caption">
                                    <div class="caption">
                                        <h3>raptor hide harness</h3>
                                        <p><a href="auction_item.php?id=<?php echo '104'; ?>" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="thumbnail">
                            <a href="cart.php">
                                <img src="img/105.jpg" alt="">
                            </a>
                            <center>
                                <div class="caption">
                                    <h3>bouquet of red rose</h3>
                                    <p><a href="auction_item.php?id=<?php echo '105'; ?>" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    
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