<?php
	session_start();
    require 'connection.php';
    $category=mysqli_real_escape_string($con,$_POST['category']);
    $subcategory1=mysqli_real_escape_string($con,$_POST['subcategory1']);
    $subcategory2=mysqli_real_escape_string($con,$_POST['subcategory2']);
    $subcategory3=mysqli_real_escape_string($con,$_POST['subcategory3']);
    echo $category;
    echo $subcategory1;
    echo $subcategory2;
    echo $subcategory3;
    if($category==1){
        if($subcategory1==1){
            header("location: category.php?type_id=1");
        }elseif($subcategory1==2){
            header("location: category.php?type_id=2");
        }elseif($subcategory1==3){
            header("location: category.php?type_id=3");
        }
    }elseif ($category==2) {
        if($subcategory2==4){
            header("location: category.php?type_id=7");
        }elseif($subcategory2==5){
            header("location: category.php?type_id=8");
        }elseif($subcategory2==6){
            header("location: category.php?type_id=9");
        }
    }elseif($category==3){
        if($subcategory3==7){
            header("location: category.php?type_id=4");
        }elseif($subcategory3==8){
            header("location: category.php?type_id=5");
        }elseif($subcategory3==9){
            header("location: category.php?type_id=6");
        }
    }
?>