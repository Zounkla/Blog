<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>S'inscrire</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="register.css"/>
  </head>
  
  <body>
    <h1>Inscription</h1>
    <div class='inscription'>
      <form action="register.php" method="post">
        <p id='pseudo'>
          Pseudo : <input type = "text" name="login" maxlength="25" 
                   placeholder="25 caractères max"/>
        </p>
        <p id='mdp1'>
          Mot de passe : <input type = "password" name="mdp1" maxlength="20" 
                         placeholder="20 caractères max"/>
        </p>
        <p id='mdp2'>
          Confirmation du Mot de passe : <input type = "password" name="mdp2" 
                                          maxlength="20"/>
        </p>
        <p id='submit'>
          <input type="submit" value="S'inscrire"/>
        </p>
      </form>
    </div>
    <?php
      ini_set('display_errors', 1);
      if (isset($_POST['mdp1']) && isset ($_POST['mdp2']) 
          && isset($_POST['login'])) {
        include ('connect_login.php');
        $login = htmlentities($_POST['login'], ENT_QUOTES);
        $mdp1 = htmlentities($_POST['mdp1'], ENT_QUOTES);
        $mdp2 = htmlentities($_POST['mdp2'], ENT_QUOTES);
        if (empty($_POST['mdp1']) || empty($_POST['mdp2']) 
          || empty($_POST['login'])) {
          echo "<p class='inscription'>champ(s) vide(s)</p>";
        } else if ($mdp1 == $mdp2) {
          $requete = "INSERT INTO login VALUES('$login', '$mdp1')";
          $res = mysqli_query($connexion, $requete);
          $j = mysqli_error($connexion);
          if ($j != NULL) {
            echo "<p class='inscription'>Erreur ! Pseudo indisponible ?</p>";
          } else if ($j == NULL) {
            echo "<p class='inscription'>Bien inscrit(e)\n";
            echo "<br/>";
            echo "<br/>";
            echo "Bienvenue $login !\n";
            echo "<br/>";
            echo "<br/>";
            echo "<a href='accueil.php'>Retour à l'accueil</a></p>";
            session_start();
            $_SESSION["login"] = $login;
            $_SESSION["mdp"] = $mdp1;
            mysqli_close($connexion);
          }
        } else {
          echo "<p class='inscription'>
                Mots de passe différents. Veuillez réessayer
                </p>";
        }
      }
    ?>
    <br/>
    <br/>
    Se rétracter : <a href='accueil.php'>Retour à l'accueil</a>
    <br/>
    <br/>
  <footer id="footer">
      <a id='mentions' href ='mentions.php#mentions'> Mentions légales</a>
      <a id='droits' href ='mentions.php#droits'> Droits </a>
    </footer>
  </body>
</html>
