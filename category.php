<?php
    session_start();
    require 'connection.php';
    $type_id=$_GET['type_id'];
    //get user id
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    //get type id
    $get_type_name_query="SELECT type_name from item where type_id = '$type_id' limit 1";
    $get_type_name_result=mysqli_query($con,$get_type_name_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($get_type_name_result);
    $type_name=$row["type_name"];
    //get item id
    $item_id1=$type_id*3-2;
    $item_id2=$type_id*3-1;
    $item_id3=$type_id*3;
    //get item name
    $get_item_name_query="SELECT item_name from item where item_id='$item_id1'";
    $get_item_name_result=mysqli_query($con,$get_item_name_query) or die(mysqli_error($con));
    $row=mysqli_fetch_array($get_item_name_result);
    $item_name1=$row['item_name'];
    $get_item_name_query="SELECT item_name from item where item_id='$item_id2'";
    $get_item_name_result=mysqli_query($con,$get_item_name_query) or die(mysqli_error($con));
    $row=mysqli_fetch_array($get_item_name_result);
    $item_name2=$row['item_name'];
    $get_item_name_query="SELECT item_name from item where item_id='$item_id3'";
    $get_item_name_result=mysqli_query($con,$get_item_name_query) or die(mysqli_error($con));
    $row=mysqli_fetch_array($get_item_name_result);
    $item_name3=$row['item_name'];
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
        <script type="text/javascript">
            $(document).ready(function() {
                $('#subcategory2').hide();
                $('#subcategory3').hide();
                 $('#category').change(function () {
                    if ($('#category option:selected').text() == "Gaming_gears" ){
                        $('#subcategory1').show();
                    }
                     else if($('#category option:selected').text() == "Toys"){ 
                          $('#subcategory2').show();
                          $('#subcategory1').hide();
                     }
                     else if($('#category option:selected').text() == "Apparel"){ 
                          $('#subcategory3').show();
                          $('#subcategory1').hide();
                          $('#subcategory2').hide();
                     }
                });
            });
        </script>
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
                    <h4>Browser History</h4>
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
                            <img src="img/<?php echo $type_id;?>A.jpg" alt="">
                            <center>
                                <div class="caption">
                                    <h6><?php echo $item_name1;?></h6>
                                    <p><a href="product.php?id=<?php echo $item_id1;?>" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <br><br><br>
                        <div class="thumbnail">
                            <img src="img/<?php echo $type_id;?>B.jpg" alt="">
                            <center>
                                <div class="caption">
                                    <div class="caption">
                                        <h6><?php echo $item_name2;?></h6>
                                        <p><a href="product.php?id=<?php echo $item_id2;?>" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    </div>
                                </div>
                            </center>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4">
                        <br><br><br>
                        <div class="thumbnail">
                            <img src="img/<?php echo $type_id;?>C.jpg" alt="">
                            <center>
                                <div class="caption">
                                    <h6><?php echo $item_name3;?></h6>
                                    <p><a href="product.php?id=<?php echo $item_id3;?>" role="button" class="btn btn-primary btn-block">Check it out!</a></p>
                                    
                                </div>
                            </center>
                        </div>
                    </div>
                </div>    
            </div>
            <br><br><br><br><br><br><br><br>
           <footer class="footer"> 
               <div class="container">
               <center>
                   <p>Copyright &copy Eauction. All Rights Reserved.</p>
                   <p>This website is developed by A Squad</p>
               </center>
               </div>
           </footer>
        </div>
    </body>
</html>
