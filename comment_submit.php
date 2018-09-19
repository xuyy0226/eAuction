<?php
	session_start();
	require 'connection.php';
	$item_id=$_GET['item_id'];
	$order_id=$_GET['order_id'];

	$comments=mysqli_real_escape_string($con,$_POST['comments']);
	$stars=(int)mysqli_real_escape_string($con,$_POST['stars']);
	echo $stars;
	$update_containreview_query="UPDATE containreview set stars='$stars', content='$comments' where item_id='$item_id' and order_id='$order_id'";
	$update_containreview_result=mysqli_query($con,$update_containreview_query) or die(mysqli_error($con));
	header("location: product_comment.php?order_id=$order_id")
?>