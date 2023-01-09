<?php function affiche($mdp) {
  $r = 0;
  while ($r < strlen($mdp)) {
    echo "*";
    ++$r;
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Profil</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="profil.css"/>
  </head>

  <body>
  <h1>Gestion de profil</h1>
  <?php
    ini_set("display_errors", 1);
    session_start();
    if (isset($_SESSION['login']) && isset ($_SESSION['mdp'])) {
      $login = $_SESSION['login'];
      $mdp = $_SESSION['mdp'];
      echo "<h2>Informations personnelles</h2>";
      echo "Pseudo : $login";
      echo "<br/>";
      echo "<br/>";
      echo "Mot de passe : <abbr title='$mdp'>"; 
      affiche($mdp);
      echo "</abbr>";
      echo "<br/>";
      echo "<br/>";
      echo "<a href='accueil.php'>Retour à l'accueil</a>";
      echo "<br/>";
      echo "<br/>";
      echo "<div class='new'>";
      echo "<h2 id='modif'>Modifications</h2>";
      echo "<form id='update' method='post'>";
      echo "<p id='login'>";
      echo "Changer de pseudo : <input type='text' name='newlogin' 
            placeholder='nouveau pseudo de 25 caractères max' maxlength='25'>";
      echo "</p>";
      echo "<p id='mdp1'>";
      echo "Changer de mot de passe : <input type ='password' name='newmdp1' 
            placeholder='nouveau mdp de 20 caractères max' maxlength='20'>";
      echo "</p>";
      echo "<p id='mdp2'>";
      echo "Confirmer nouveau mot de passe : <input type ='password' 
            name='newmdp2' placeholder='confirmer mdp' maxlength='20'>";
      echo "</p>";
      echo "<p id='submit'>";
      echo "<input type='submit' value='Mettre à jour'/>";
      echo "</p>";
      echo "</form>";
      echo "</div>";
      if (isset($_POST['newlogin']) && isset($_POST['newmdp1']) 
          && isset($_POST['newmdp2'])) {
        $newlogin = htmlentities($_POST['newlogin'], ENT_QUOTES);
        $newmdp1 = htmlentities($_POST['newmdp1'], ENT_QUOTES);
        $newmdp2 = htmlentities($_POST['newmdp2'], ENT_QUOTES);
        if (empty($_POST['newmdp1']) || empty($_POST['newmdp2']) 
            || empty($_POST['newlogin'])) {
          echo "<p class='new'> champ(s) vide(s)</p>";
        } else if ($newmdp1 == $newmdp2) {
          include ('connect_login.php');
          if ($login != $newlogin) {
            $requete = "UPDATE login SET id='$newlogin' WHERE id='$login'";
            if ($res = mysqli_query($connexion, $requete) == TRUE) {
              $requete1 = "UPDATE login SET mdp='$newmdp1' 
                          WHERE id='$newlogin'";
              $res1 = mysqli_query($connexion, $requete1);
              $requete2 = "UPDATE commentaires SET auteur='$newlogin' 
                          WHERE auteur='$login'";
              $res2 = mysqli_query($connexion, $requete2);
            }
          } else {
            $requete = "UPDATE login SET mdp='$newmdp1' WHERE id='$login'";
            $res = mysqli_query($connexion, $requete);
          }
          $j = mysqli_error($connexion);
          if ($j != NULL) {
            echo "<p class='new'>Erreur ! Pseudo indisponible ?</p>";
            echo "<br/>";
            echo "<br/>";
          } else if ($j == NULL) {
            echo "<p class='new'>Bien mis à jour</p>\n";
            echo "<br/>";
            echo "<br/>";
            echo "<br/>";
            $_SESSION["login"] = $newlogin;
            $_SESSION["mdp"] = $newmdp1;
            header("Refresh: 2");
            mysqli_close($connexion);
          }
        } else {
          echo "<p class='new'>Mots de passe différents. 
                Veuillez réessayer</p>";
          echo "<br/>";
          echo "<br/>";
        }
        echo "<br/>";
      }
      echo "<h2>Suppression</h2>";
      echo "<form id='delete' method='post'>";
      echo "<abbr title='Attention ! La suppresion du compte est permanente. 
            Appuyer sur le bouton seulement si vous êtes sûr(e) de vous !'>
            Supprimer votre compte : </abbr>
            <input type='submit' value='Supprimer' name='del'>";
      echo "</form>";
      echo "<br/>";
      echo "<br/>";
      if (isset ($_POST['del'])) {
        include ('connect_login.php');
        $requete1 = "DELETE FROM commentaires where auteur='$login'";
        $res1 = mysqli_query($connexion, $requete1);
        $requete = "DELETE FROM login where id='$login'";
        $res = mysqli_query($connexion, $requete);
        mysqli_close($connexion);
        echo "bien supprimé";
        echo "<br/>";
        echo "<a href='accueil.php'>Retour à l'accueil</a>";
        session_destroy();
        header("location: accueil.php");
      }
      echo "<h2>Statistiques</h2>";
      include ('connect_login.php');
      $requete = "SELECT * FROM commentaires WHERE auteur = '$login'";
      $res = mysqli_query($connexion, $requete);
      $nbcomm = mysqli_num_rows($res);
      echo ("$nbcomm commentaire");
      if ($nbcomm > 1) {
        echo ("s");
      }
      echo "<form id='del' method='post'>";
      echo "<select name='liste'>";
      while ($row = mysqli_fetch_array($res)) {
        $requete1 = "SELECT titre FROM articles 
                    WHERE num = '{$row['num_article']}'";
        $res1 = mysqli_query($connexion, $requete1);
        $row1 = mysqli_fetch_array($res1);
        echo "<option value='{$row['id']}'>{$row['texte']}  {$row['date']}";
        echo " {$row1['titre']}</option>";
      }
      echo "</select>";
      echo "<br/>";
      echo "<br/>";
      echo "<input type='submit' value='Supprimer' name='delete'>";
      echo "</form>";
      if (isset ($_POST['delete']) && isset($_POST['liste'])) {
        $liste = $_POST['liste'];
        $requete2 = "DELETE FROM commentaires where id=$liste";
        $res2 = mysqli_query($connexion, $requete2);
        echo "commentaire bien supprimé !";
        header("Refresh: 2");
      }
      echo "<br/>";
    }
?>
  
  <footer id="footer">
      <a id='mentions' href ='mentions.php#mentions'> Mentions légales</a>
      <a id='droits' href ='mentions.php#droits'> Droits </a>
    </footer>
  </body>
</html>
