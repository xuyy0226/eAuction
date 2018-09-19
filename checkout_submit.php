<?php
    require 'connection.php';
    session_start();
    //get user_id
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];

    //update card information
    $name_on_card=mysqli_real_escape_string($con,$_POST['name_on_card']);
    $card_number=mysqli_real_escape_string($con,$_POST['card_number']);
    $expiration_date=mysqli_real_escape_string($con,$_POST['expiration_date']);
    $cvv=mysqli_real_escape_string($con,$_POST['cvv']);

    $insert_card_query="INSERT INTO paywithpayment(name_on_card,card_number,expiration_date,cvv,uid) VALUES ('$name_on_card','$card_number','$expiration_date','$cvv','$user_id')";
    $insert_card_result=mysqli_query($con,$insert_card_query) or die(mysqli_error($con));

    //update shipment information
    $shipprice=mysqli_real_escape_string($con,$_POST['shipprice']);
    // echo '111';
    // echo $shipprice;
    if($shipprice==2){
        $ship_time=2;
        $ship_price=25;
    }elseif($shipprice==3){
        $ship_time=3;
        $ship_price=15;
    }elseif($shipprice==4){
        $ship_time=4;
        $ship_price=8;
    }
   
    $get_price_query="select total_price from hascart where uid='$user_id' and order_id = 0 LIMIT 1";
    $get_price_result=mysqli_query($con,$get_price_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($get_price_result);
    $current_price=$row["total_price"];
    $update_total_price_query="UPDATE hascart SET total_price='$current_price'+'$ship_price' where uid='$user_id' and order_id = 0";
    $update_total_price_result=mysqli_query($con,$update_total_price_query) or die(mysqli_error($con));
    $total_price=$current_price+$ship_price;


    // echo $ship_time;
    // echo '   ';
    // echo $ship_price;
    // echo '   ';
    // echo $current_price+$ship_price;

    //get all the information from front end
    $firstname=mysqli_real_escape_string($con,$_POST['firstName']);
    $lastname=mysqli_real_escape_string($con,$_POST['lastName']);
    $address=mysqli_real_escape_string($con,$_POST['address']);
    $address2=mysqli_real_escape_string($con,$_POST['address2']);
    $zipcode=mysqli_real_escape_string($con,$_POST['zipcode']);
    $phone=mysqli_real_escape_string($con,$_POST['phone']);
    $is_shipping=mysqli_real_escape_string($con,$_POST['is_shipping']);
    $is_billing=mysqli_real_escape_string($con,$_POST['is_billing']);
    $city=mysqli_real_escape_string($con,$_POST['city']);
    $state=mysqli_real_escape_string($con,$_POST['state']);


    if($is_billing="Incorrect"){
    	$is_billing=0;
    }else{
    	$is_billing=1;
    }


    //generate random address id
    $address_id=rand(1,100000000);
    $check_exist_query="SELECT address_id FROM address WHERE address_id = '$address_id'";
    $check_exist_result=mysqli_query($con,$check_exist_query) or die(mysqli_error($con));
    while(mysqli_num_rows($check_exist_result)>0){
        $address_id=rand(1,100000000);
        $check_exist_query="SELECT address_id FROM address WHERE address_id = '$address_id'";
    	$check_exist_result=mysqli_query($con,$check_exist_query) or die(mysqli_error($con));
    }

    $zipcode_query = "select * from address2 where zipcode = '$zipcode'";
    $zipcode_result = mysqli_query($con,$zipcode_query) or die(mysqli_error($con));
    if (mysqli_num_rows($zipcode_result)==0){
    	$address2_query = "insert into address2(zipcode,city,state) values('$zipcode','$city','$state')";
    	$address_result=mysqli_query($con,$address2_query) or die(mysqli_error($con));
    }
    	$insert_address_query = "INSERT INTO address(lastname, firstname, addressline_1, addressline_2, zipcode, phone, is_billing, address_id, UID) VALUES ('$lastname','$firstname','$address','$address2','$zipcode','$phone','$is_billing','$address_id','$user_id')";
    	$insert_address_result=mysqli_query($con,$insert_address_query) or die(mysqli_error($con));

    	$user_products_query="select distinct(i.item_id) as item_id, h.quantity as quantity from include i, hascart h, users u where h.uid=u.uid and i.cart_id = h.cart_id and u.uid = '$user_id' ";
    	$user_products_result=mysqli_query($con,$user_products_query) or die(mysqli_error($con));
    	while($row=mysqli_fetch_assoc($user_products_result)){ 
    		$item_id=$row["item_id"];
    		$quantity=$row["quantity"];
    		$stock_update_query="update normalitem set stock_info=stock_info-'$quantity' where item_id='$item_id'";
    		$stock_update_result=mysqli_query($con,$stock_update_query) or die(mysqli_error($con));
    	}

       //update purorder table and trackpackage table
        $select_max_order_query="SELECT max(order_id) FROM purorder ";
        $select_max_order_result=mysqli_query($con,$select_max_order_query) or die(mysqli_error($con));
        if(mysqli_num_rows($select_max_order_result)==0){
            $order_id=0;
        }else{
            $row=mysqli_fetch_assoc($select_max_order_result);
            $order_id=$row['max(order_id)']+1;
        }
        // while(mysqli_num_rows($check_exist_result)>0){
        //     $order_id=rand(1,100000000);
        //     $check_exist_query="SELECT address_id FROM address WHERE address_id = '$order_id'";
        //     $check_exist_result=mysqli_query($con,$check_exist_query) or die(mysqli_error($con));
        // }
        $get_quantity_query="select count(quantity) as quantity from (select DISTINCT(i.item_id), h.quantity from hascart h, include i where uid='$user_id' and h.cart_id=i.Cart_id) as TEMP";
        $get_quantity_result=mysqli_query($con,$get_quantity_query) or die(mysqli_error($con));
        $row=mysqli_fetch_assoc($get_quantity_result);
        $total_quantity=$row['quantity'];
        date_default_timezone_set("America/New_York");
        $today_date = date('Y-m-d H:i:s');
        $purorder_query="INSERT INTO purorder(order_id,quantity,total_price,today_date,ship_time,uid,address_id) VALUES('$order_id','$total_quantity','$total_price','$today_date','$ship_time','$user_id','$address_id')";
        $purorder_result=mysqli_query($con,$purorder_query) or die(mysqli_error($con));

        //update trackpackage table
        $track_num=rand(1,100000000);
        $check_exist_query="SELECT track_num FROM trackpackage WHERE track_num = '$track_num'";
        $check_exist_result=mysqli_query($con,$check_exist_query) or die(mysqli_error($con));
        while(mysqli_num_rows($check_exist_result)>0){
            $track_num=rand(1,100000000);
            $check_exist_query="SELECT track_num FROM trackpackage WHERE track_num = '$track_num'";
            $check_exist_result=mysqli_query($con,$check_exist_query) or die(mysqli_error($con));
        }
        $insert_trackpackage_query="insert into trackpackage(track_num,order_id) values('$track_num','$order_id')";
        $insert_trackpackage_result=mysqli_query($con,$insert_trackpackage_query) or die(mysqli_error($con));
        $_SESSION['has_checkout']=1;

    	header("location: success.php?id=$address_id");
    ?>