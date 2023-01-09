<?php 
  $password = "toBeDefined";
  $connexion = mysqli_connect("localhost", "vanliflo", $password, "vanliflo");
  echo mysqli_connect_error();
  echo mysqli_error($connexion);
?>
