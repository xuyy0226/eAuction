<?php
  DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'xyyxthd38');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_DATABASE', 'Eauction');

  $con=mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
  }



?>
