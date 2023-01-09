<?php 
  ini_set('display_errors', 1);
  if (isset($_POST['comm'])) {
    if (empty($_POST['comm'])) {
      echo "champ vide\n";
      echo "<br/>";
      echo "<br/>";
    } else {
      $auteur = $_SESSION["login"];
      include ('connect_login.php');
      $texte = htmlentities($_POST['comm'], ENT_QUOTES);
      $date = date("y/m/d");
      $id = $_GET['ID'];
      $requete = "INSERT INTO commentaires(auteur, texte, date, num_article) 
                  VALUES('$auteur', '$texte', '$date', '$id')";
      $res = mysqli_query($connexion, $requete);
      $j = mysqli_error($connexion);
      if ($j != NULL) {
        echo "Erreur !";
      } else if ($j == NULL) {
        echo "Commentaire bien écrit\n";
      }
      mysqli_close($connexion);
    }
  }
?>

