<?php
    require 'connection.php';
    //require 'header.php';
    session_start();
    //get uid and current cart item id
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    $item_id=$_GET['id'];
    echo $item_id;
    //get item price
    $price_query = "Select price From item  WHERE item_id='$item_id'";
    $price_result=mysqli_query($con,$price_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($price_result);
    $price=$row["price"];
    //get cart id
    $cart_id=rand(1,100000000);
    $check_exist_query="SELECT cart_id FROM hascart WHERE cart_id = 'cart_id'";
    $check_exist_result=mysqli_query($con,$check_exist_query) or die(mysqli_error($con));
    while(mysqli_num_rows($check_exist_result)>0){
        $cart_id=rand(1,100000000);
    }
    $has_cart_query="insert into hascart(cart_id,quantity,total_price,UID) values('$cart_id','0','0','$user_id')";
    $has_cart_result=mysqli_query($con,$has_cart_query) or die(mysqli_error($con));

    //get the original total price
    $check_cart_num_query="select * from hascart where uid='$user_id' and order_id=0";
    $check_cart_num_result=mysqli_query($con,$check_cart_num_query) or die(mysqli_error($con));
    if(mysqli_num_rows($check_cart_num_result)>1){
        $get_price_query="select total_price from hascart where uid='$user_id' and cart_id <> '$cart_id' and order_id=0 LIMIT 1";
        $get_price_result=mysqli_query($con,$get_price_query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($get_price_result);
        $current_price=$row["total_price"];
    }

    $include_query="INSERT into include(Cart_id,item_id) values ('$cart_id','$item_id')";
    $include_result=mysqli_query($con,$include_query) or die(mysqli_error($con));

    $quantity_query ="select count(i.item_id) as quan from include i, hascart h where h.uid = '$user_id' and h.cart_id = i.cart_id and i.item_id = '$item_id' and order_id = 0";
    $quantity_result = mysqli_query($con,$quantity_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($quantity_result);
    $quantity=$row["quan"];

    $get_cart_query = "select i.cart_id from include i, hascart h where h.cart_id=i.Cart_id and h.uid = '$user_id' and i.item_id = '$item_id' and h.order_id= 0";
    $get_cart_result = mysqli_query($con,$get_cart_query) or die(mysqli_error($con));

    while ( $row=mysqli_fetch_array($get_cart_result)) {
        $get_cart = $row["cart_id"];
        $has_cart_query="UPDATE hascart SET quantity='$quantity',total_price='$current_price'+'$price' WHERE uid='$user_id' and cart_id = '$get_cart' and order_id=0";
        $has_cart_result=mysqli_query($con,$has_cart_query) or die(mysqli_error($con));
    }
    $update_rest_query="UPDATE hascart SET total_price='$current_price'+'$price' WHERE uid='$user_id' and order_id=0 ";
    $update_rest_result=mysqli_query($con,$update_rest_query) or die(mysqli_error($con));
    header('Location: ' . $_SERVER['HTTP_REFERER']);
?>