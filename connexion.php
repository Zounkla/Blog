<?php
  session_start();
  ini_set('display_errors', 1);
  if (isset($_POST['login']) && isset ($_POST['mdp'])) {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];
    include ('connect_login.php');
    $requete = "SELECT * FROM login WHERE id = '$login' and mdp ='$mdp'";
    $res = mysqli_query($connexion, $requete);
    $id = mysqli_num_rows($res);
    if ($id == 1) {
      echo "Bienvenue $login !\n";
      $_SESSION["login"] = $login;
      $_SESSION["mdp"] = $mdp;
    } else {
      echo "Combinaison erronée !\n";
      echo "Veuillez réessayer\n";
    }
     mysqli_close($connexion);
  }
?>
