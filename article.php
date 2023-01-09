<?php 
  session_start();
  function delete() {
    if (isset($_SESSION['login']) && isset ($_SESSION['mdp'])) {
      $login = $_SESSION['login'];
      $mdp = $_SESSION['mdp'];
      include ('connect_login.php');
      $requete = "SELECT * FROM login WHERE id='Zounkla'";
      $res = mysqli_query($connexion, $requete);
      while ($admin = mysqli_fetch_array($res)) {
        if ($mdp === $admin['mdp']) {
          echo "<form id='delete' method='post'>";
          echo "<select name='liste'>";
          $requete1 = "SELECT * FROM commentaires";
          $res1 = mysqli_query($connexion, $requete1);
          while ($row = mysqli_fetch_array($res1)) {
            if (($row['num_article']) == $_GET['ID']) {
              echo "<option value='{$row['id']}'>{$row['auteur']} 
                    {$row['texte']} {$row['date']}</option>";
              }
            }
            echo "</select>";
            echo "<br/>";
            echo "<br/>";
            echo "<input type='submit' value='Supprimer' name='del'>";
            echo "</form>";
            if (isset ($_POST['del']) && isset($_POST['liste'])) {
              $liste = $_POST['liste'];
              $requete2 = "DELETE FROM commentaires where id=$liste";
              $res2 = mysqli_query($connexion, $requete2);
              header("Refresh: 2");
            }
            echo "<br/>";
            echo "<form id='suppr' method='post'>";
            echo "<input type='submit' value='Supprimer article' name='suppr'>";
            echo "</form>";
            if (isset($_POST['suppr'])) {
              $num = $_GET['ID'];
              $requete3 = "DELETE FROM articles WHERE num = '$num'";
              $res3 = mysqli_query($connexion, $requete3);
              $requete4 = "DELETE FROM commentaires where num_article='$num'";
              $res4 = mysqli_query($connexion, $requete4);
              header("location: accueil.php");
            }
          }
        }
        mysqli_close($connexion);
      }
    }
 ?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Article</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="article.css"/>
  </head>
  <body>
<?php
  include ('connect_login.php');
  $requete = "SELECT * FROM articles";
  $res = mysqli_query($connexion, $requete);
  $article = mysqli_fetch_array($res);
  $id = $_GET['ID'];
  $requete1 = "SELECT * FROM articles WHERE num =$id";
  $res = mysqli_query($connexion, $requete1);
  echo mysqli_error($connexion);
  $article1 = mysqli_fetch_array($res);
  if ($id == $article1['num']) {
    echo "<div id='article'>";
    echo "<div class='title'>{$article1['titre']}\n</div>";
    echo "<div class='date'>le {$article1['date']}\n</div>";
    echo "<br/>";
    echo "<div class='texte'>";
    echo "{$article1['texte']}";
    echo "</div>";
    echo "<br/>";
    echo "</div>";
    echo "<br/>";
  }
  delete();
  mysqli_close($connexion);
  
  if (!isset($_SESSION["login"]) || !isset($_SESSION["mdp"])) {
    echo "Pas encore connecté ?";
    echo "<br/>";
    echo "Se connecter pour commenter !\n";
    echo "<a href='accueil.php'> Retour à l'accueil </a>";
    echo "<br/>";
  } else {
    echo '<p>';
    echo 'Ecrire un commentaire';
    echo '</p>';
    echo '<form method="post">';
    echo '<p>';
    echo '<textarea  name="comm" placeholder="Ecrire ici" rows="10" cols="50" 
          maxlength="4294967296" spellcheck="true"></textarea>';
    echo '</p>';
    echo '<p id="send">';
    echo '<input type="submit" value="Envoyer" name="send"/>';
    echo '</p>';
    echo '</form>';
    echo "<a href='accueil.php'>Retour à l'accueil</a>";
    echo "<br/>";
    echo "<br/>";
  }
  
  if (isset($_POST['send'])) {
    header("Refresh: 2");
  }
  
  include ('commentaire.php');
  echo "<br/>";
  echo "<br/>";
  include ('connect_login.php');
  $id = $_GET['ID'];
  $requete = "SELECT * FROM commentaires WHERE num_article = '$id'";
  $res = mysqli_query($connexion, $requete);
  $nbcomm = mysqli_num_rows($res);
  echo ("$nbcomm commentaire");
    if ($nbcomm > 1) {
      echo ("s");
    }
    while ($comm = mysqli_fetch_array($res)) {
      if($comm['num_article'] == $id) {
        echo "<div class='commentaires'>";
        echo "<br/>";
        echo "<br/>";
        echo "{$comm['auteur']} a dit :\n";
        echo "{$comm['texte']}\n";
        echo "le {$comm['date']}\n";
        echo "<br/>";
        echo "</div>";
        echo "<br/>";
      }
    }
    mysqli_close($connexion);
?>
<br/>
<footer id="footer">
  <a id='mentions' href ='mentions.php#mentions'> Mentions légales</a>
  <a id='droits' href ='mentions.php#droits'> Droits </a>
</footer>
</body>
</html>
