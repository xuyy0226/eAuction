<?php
    require 'connection.php';
    session_start();
    $name=mysqli_real_escape_string($con,$_POST['name']);
    $password=mysqli_real_escape_string($con,$_POST['password']);
    if(strlen($password)<6){
        echo "Password should have atleast 6 characters. Redirecting you back to login page...";
        ?>
        <meta http-equiv="refresh" content="2;url=login.php" />
        <?php
    }
    $user_authentication_query="select username from userlogin where username='$name' and password='$password'";
    $user_authentication_result=mysqli_query($con,$user_authentication_query) or die(mysqli_error($con));
    $rows_fetched=mysqli_num_rows($user_authentication_result);
    if($rows_fetched==0){
        //no user
        //redirecting to same login page
        ?>
        <script>
            window.alert("Wrong username or password");
        </script>
        <meta http-equiv="refresh" content="1;url=login.php" />
        <?php
        //header('location: login');
        //echo "Wrong email or password.";
    }else{
        $row=mysqli_fetch_array($user_authentication_result);
        $uid_query = "select uid from users where username='$name'";
        $uid_result=mysqli_query($con,$uid_query) or die(mysqli_error($con));
        $row = mysqli_fetch_assoc($uid_result);
        $uid=$row["uid"];
        echo $uid;
        echo $name;
        $_SESSION['id']=$uid;
        echo $_SESSION['id'];
        $_SESSION['username']=$name;
        header('location: index.php');
    }
    
 ?>