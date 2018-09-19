<?php
    require 'connection.php';
    session_start();
    //get uid and current cart item id
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    $item_id=$_GET['id'];

    $delete_include_query="DELETE i FROM hascart h, include i WHERE i.Cart_id=h.cart_id and h.uid = '$user_id' and h.order_id=0";
    $delete_include_result=mysqli_query($con,$delete_include_query) or die(mysqli_error($con));
    $delete_hascart_query="DELETE FROM hascart  WHERE uid = '$user_id'";
    $delete_hascart_result=mysqli_query($con,$delete_hascart_query) or die(mysqli_error($con));
    header('location: cart.php');
?>