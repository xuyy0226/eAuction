<?php
require 'connection.php';
session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="#" />
        <title>Eauction</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- latest compiled and minified CSS -->
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
           <div id="bannerImage">
               <div class="container">
                   <center>
                   <div id="bannerContent">
                       <h1>You Can Bid Here!</h1>
                       <p>Find things special here</p>
                       <a href="bid_item.php" class="btn btn-danger">Bid Now</a>
                   </div>
                   </center>
               </div>
           </div>
           <div class="container">
               <div class="row">
                   <div class="col-xs-4">
                       <div  class="thumbnail">
                           <a href="product_gaming_gear.php">
                                <img src="img/game_gear.jpg" alt="Gaming Gears">
                           </a>
                           <center>
                                <div class="caption">
                                        <p id="autoResize">Gaming Gears</p>
                                        <p>Boost your game experience.</p>
                                </div>
                           </center>
                       </div>
                   </div>
                   <div class="col-xs-4">
                       <div class="thumbnail">
                           <a href="product_toys.php">
                               <img src="img/Toys.jpg" alt="Toys">
                           </a>
                           <center>
                                <div class="caption">
                                    <p id="autoResize">Toys</p>
                                    <p>Original watches from the best brands.</p>
                                </div>
                           </center>
                       </div>
                   </div>
                   <div class="col-xs-4">
                       <div class="thumbnail">
                           <a href="product_apparel.php">
                               <img src="img/Apparel.jpg" alt="Apparel">
                           </a>
                           <center>
                               <div class="caption">
                                   <p id="autoResize">Apparel</p>
                                   <p>Our exquisite collection of shirts.</p>
                               </div>
                           </center>
                       </div>
                   </div>
               </div>
           </div>
            <br><br> <br><br><br><br>
            <br><br> <br><br><br><br>
           <?php
                require 'footer.php';
            ?>
        </div>
    </body>
</html>