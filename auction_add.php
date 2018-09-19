<?php
	session_start();
	require 'connection.php';
	$item_id=$_GET['id'];
	//get user_id
	$name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    //update table
    echo $user_id;
    $update_auctionitem_query="UPDATE auctionitem set winner_uid='$user_id' where item_id='$item_id'";
    $update_auctionitem_result=mysqli_query($con,$update_auctionitem_query) or die(mysqli_error($con));
    echo "success";
    $get_auctionitem_query="select increment from auctionitem where item_id='$item_id'";
    $get_auctionitem_result=mysqli_query($con,$get_auctionitem_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($get_auctionitem_result);
    $increment=$row['increment'];
    $update_price_query="UPDATE item set price=price+'$increment'where item_id='$item_id'";
    $update_price_result=mysqli_query($con,$update_price_query) or die(mysqli_error($con));
    header("location: auction_item.php?id=$item_id");
?>