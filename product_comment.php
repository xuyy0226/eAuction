<?php
	session_start();
	require 'connection.php';
	if($_SESSION['add_comment']!=1){
		header('location: index.php');
	}
	$order_id=$_GET['order_id'];
	$get_item_query="SELECT * FROM containreview where order_id='$order_id'";

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
        <link rel="stylesheet" href="css/style.css" type="text/css">
    </head>
    <body>

    <!-- Navigation -->
    <?php
        require 'header.php';
    ?>

    <!-- Page Content -->
    <div class="container">
      <br><br><br><br><br>
      	<?php $get_item_result=mysqli_query($con,$get_item_query) or die(mysqli_error($con));
      		while($row=mysqli_fetch_array($get_item_result)){
      			$item_id=$row['item_id'];
      			//get item name
      			$get_item_name_query="select item_name from item where item_id='$item_id'";
      			$get_item_name_result=mysqli_query($con,$get_item_name_query) or die(mysqli_error($con));
      			$row=mysqli_fetch_array($get_item_name_result);
      			$item_name=$row['item_name'];
      	?>
        <form  method="post" action="comment_submit.php?order_id=<?php echo $order_id; ?>
                                            &item_id=<?php echo $item_id; ?>">      
      <div class="row"> 
        <div class="col-lg-6 col-md-6 col-sm-6">
        	<div class="form-group">
    			<label for="exampleFormControlTextarea1">Add your comments for <?php echo $item_name;?></label>
    			<textarea class="form-control" id="comments"  name="comments" rows="3"></textarea>
  			</div>  
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
        	<div>
        		<label for="exampleFormControlTextarea1">Add your rating(0-5)</label>
        		<input class="form-control form-control-sm" type="text" name="stars" placeholder="5">
        	</div>
        </div>
    	
        <!-- /.col-lg-6 -->
      </div>
      <div class="row">
      	<div class="col-lg-2 col-md-2 col-sm-2">
      		<button class="btn btn-success" type="submit">Submit Comment</button>
      	</div>
      </div>
      </form>
      <?php }?>
    </div>
    <br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br>
    <br><br><br><br><br><br><br><br>
    <!-- /.container -->
    <!-- Footer -->
    <?php
                require 'footer.php';
            ?>
  </body>
</html>