<?php
    require 'connection.php';
    session_start();
    $name= mysqli_real_escape_string($con,$_POST['name']);

    $password=mysqli_real_escape_string($con,$_POST['password']);
    if(strlen($password)<6){
        echo "Password should have at least 6 characters. Redirecting you back to registration page...";
        ?>
        <meta http-equiv="refresh" content="2;url=signup.php" />
        <?php
    }

    $duplicate_user_query="select * from userlogin where username = '$name'";
    $duplicate_user_result=mysqli_query($con,$duplicate_user_query) or die(mysqli_error($con));
    $rows_fetched=mysqli_num_rows($duplicate_user_result);
    if($rows_fetched>0){

        ?>
        <script>
            window.alert("username already exists in our database!");
        </script>
        <meta http-equiv="refresh" content="1;url=signup.php" />
        <?php
    }else{
        $user_registration_query="insert into userlogin(username,PASSWORD) values ('$name','$password')";
        //die($user_registration_query);
        $user_registration_result=mysqli_query($con,$user_registration_query) or die(mysqli_error($con));
        //$_SESSION['id']=mysqli_insert_id($con);
        $max_query = "Select max(U.UID) From users U";
        $max_result=mysqli_query($con,$max_query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($max_result);
        $uid=$row["max(U.UID)"]+1;
        $_SESSION['id']=$uid;

        $user_query_="insert into users(uid,username,is_company) values ('$uid','$name','0')";
        $users_result=mysqli_query($con,$user_query_) or die(mysqli_error($con));

        ?>
        <meta http-equiv="refresh" content="3;url=login.php" />
        <?php
    }
    
?>