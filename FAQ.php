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
        <!-- External CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>
        <div>
           <?php
            require 'header.php';
           ?>
          <div class="container">
           <h1>FAQ</h1>
           <h5>User Name</h5>
           Your User name should be at leat 6 character, and it should not be the same as others.<br>

           <h5>CAPS Lock and NUM Lock on Your Keyboard</h5>
            Passwords are case sensitive, so "PASSWORD" and "Password" are recognized as two  different passwords.<br>

           <h5>Incorrect Password </h5>
            If you're sure you're using the correct e-mail address or mobile phone number, <br>you’re   your different password. <br>
           <h5>To determine the applicable shipping rate for items in your Cart:</h5>
           1. Select Proceed to Checkout <br>
           2. Select or add your shipping address <br>
           3. Select a shipping speed and select Continue <br>
           4. Select a payment method and select Continue <br>
           <h5>The total shipping & handling cost will be listed under Order Summary.</h5>
           <h5>To see your order and add comment: </h5>
           1. Go to setting <br>
           2. Click the order you want to add comment <br>
           3. click andd comment, add your commment, and submit <br>

           You can search for items by using drop down box search box, and we'll show <br>you all the matching results. To browse by a category, select a product category<br> from the drop-down menu next to Search and click Go. Each store will offer its own <br>

          </div>
            <br><br> <br><br><br><br>
            <br><br> <br><br><br><br>
           
        </div>
        <?php
                require 'footer.php';
            ?>
    </body>
</html>