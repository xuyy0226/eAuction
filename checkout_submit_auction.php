<?php
    require 'connection.php';
    session_start();
    //get user_id
    $name=$_SESSION['username'];
    $uid_query = "select uid from users where username='$name'";
    $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($uid_result);
    $user_id=$row["uid"];
    $item_id=$_GET['id'];
    //update card information
    $name_on_card=mysqli_real_escape_string($con,$_POST['name_on_card']);
    $card_number=mysqli_real_escape_string($con,$_POST['card_number']);
    $expiration_date=mysqli_real_escape_string($con,$_POST['expiration_date']);
    $cvv=mysqli_real_escape_string($con,$_POST['cvv']);

    $check_card_query="select * from paywithpayment where card_number= '$card_number' and name_on_card= '$name_on_card'";
    $check_card_result=mysqli_query($con,$check_card_query) or die(mysqli_error($con));
    if(mysqli_num_rows($check_card_result)==0){
        $insert_card_query="INSERT INTO paywithpayment(name_on_card,card_number,expiration_date,cvv,uid) VALUES ('$name_on_card','$card_number','$expiration_date','$cvv','$user_id')";
        $insert_card_result=mysqli_query($con,$insert_card_query) or die(mysqli_error($con));
    }
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
   
    $get_price_query="select price from item where item_id='$item_id'";
    $get_price_result=mysqli_query($con,$get_price_query) or die(mysqli_error($con));
    $row = mysqli_fetch_assoc($get_price_result);
    $current_price=$row["price"];
    $update_total_price_query="UPDATE item SET price='$current_price'+'$ship_price' where item_id='$item_id'";
    $update_total_price_result=mysqli_query($con,$update_total_price_query) or die(mysqli_error($con));
    $total_price=$current_price+$ship_price;



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

    	$quantity=1;
    	$stock_update_query="update normalitem set stock_info=stock_info-'$quantity' where item_id='$item_id'";
    	$stock_update_result=mysqli_query($con,$stock_update_query) or die(mysqli_error($con));
    	

       //update purorder table and trackpackage table
        $select_max_order_query="SELECT max(order_id) FROM purorder ";
        $select_max_order_result=mysqli_query($con,$select_max_order_query) or die(mysqli_error($con));
        if(mysqli_num_rows($select_max_order_result)==0){
            $order_id=0;
        }else{
            $row=mysqli_fetch_assoc($select_max_order_result);
            $order_id=$row['max(order_id)']+1;
        }
        
        $total_quantity=1;
        date_default_timezone_set("America/New_York");
        $today_date = date('Y-m-d H:i:s');
        $purorder_query="INSERT INTO purorder(order_id,quantity,total_price,today_date,ship_time,uid) VALUES('$order_id','$total_quantity','$total_price','$today_date','$ship_time','$user_id')";
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

    	header("location: success_auction.php?id=$address_id&item_id=$item_id");
    ?>