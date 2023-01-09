<?php
  function affiche($article) {
    echo "<br/>";
    echo "<div class='articles'>";
    echo "<a href='article.php?ID={$article['num']}'>{$article['titre']}</a>\n";
    echo "<br/>";
    echo "{$article['date']}\n";
    echo "<br/>";
    echo "</div>";
    echo "<br/>";
  }  
  
  function recherche_base($categories) {
    include ('connect_login.php');
    $requete = "SELECT * FROM articles WHERE categorie='$categories'";
    $res = mysqli_query($connexion, $requete);
    while ($article = mysqli_fetch_array($res)) {
      affiche($article);
    }
    mysqli_close($connexion);
  }
  
  function print_base() {
    include ('connect_login.php');
    $requete = "SELECT * FROM articles";
    $res = mysqli_query($connexion, $requete);
    while ($article = mysqli_fetch_array($res)) {
      affiche($article);
    }
    mysqli_close($connexion);
  }
      
  function recherche_titre() {
    include ('connect_login.php');
    if (isset($_POST['recherche'])) {
      $recherche = $_POST['recherche'];
    }
    $requete = "SELECT * FROM articles WHERE titre LIKE '$recherche%'";
    $res = mysqli_query($connexion, $requete);
    while ($article = mysqli_fetch_array($res)) {
      affiche($article);
    }
    mysqli_close($connexion);
  }
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Accueil</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="accueil.css"/>
  </head>

  <body>
    <div id='all'>
      <table>
        <tr>
        <!-- logo -->
          <th id="logo">
            <span class="logo">
              <img src="images/manette.jpg" alt="manette" width="100" 
              height="100"/>
            </span>
          </th>
        <!-- nom -->
          <th>
            <span class="Nom"> Le blog de Zounkla</span>
          </th>
        <!-- réseaux-->
          <th>
            <span class="reseaux">
              <span class="twitter"> 
                <a href="https://twitter.com/ZounkIa"> 
                  <img src="images/twitter.jpg" alt="Twitter" width="50" 
                  height="50"/>
                </a>
              </span>
              <span class="youtube">
                <a 
                href="https://www.youtube.com/channel/UCS-e8prGXfALqvCgJ6clghw"> 
                <img src="images/youtube.jpg" alt="Youtube" 
                width="50" height="50"/>
                </a>
              </span>
            </span>
          </th>
        </tr>
      </table>
      <!-- en-tête  -->
      
      <header id="header">
        <!-- Recherche -->
          <form id="select" method="post" action="accueil.php">
            <select name="categories">
                <option value="Aucun">Aucun</option>
                <option value="PC">PC</option>
                <option value="PS">PlayStation</option>
            </select>
            <p>
              <input type="submit" value="Valider"/>
            </p>
          </form>
          
          <form id="research" method="post" action="accueil.php">
            <p>
              <input type="text" name="recherche"/>
            </p>
            <p>
              <input type="submit" value="rechercher"/>
            </p>
          </form>
          
        <!-- Login -->
        
          <form id="login" method="post" action="accueil.php">
              <p>
                Login : <input type = "text" name="login"/>
              </p>
              <p>
                Mot de passe : <input type = "password" name="mdp"/>
              </p>
          
            
              <p>
                <input type="submit" value="Se connecter"/>
              </p>
              <?php include('connexion.php'); ?>
              
          </form>
          <p id="register">
            Vous n'avez pas de compte ? 
            <a href="register.php">Créez-en un !</a>
          </p>
<?php
  ini_set('display_errors', 1);
  if (isset($_SESSION['login']) && isset ($_SESSION['mdp'])) {
    $login = $_SESSION['login'];
    $mdp = $_SESSION['mdp'];
    include ('connect_login.php');
    $requete = "SELECT * FROM login WHERE id='Zounkla'";
    $res = mysqli_query($connexion, $requete);
    while ($admin = mysqli_fetch_array($res)) {
      if ($mdp === $admin['mdp']) {
        echo  "<form id='ecrire' method='post' action='ecrire.php'>";
        echo  "<p>";
        echo  "<input type='submit' value='Ecrire un article'/>";
        echo  "</p>";
        echo "<br/>";
        echo "</form>";
      }
    }
    mysqli_close($connexion);
  }
  if (!empty($_SESSION["login"]) && !empty($_SESSION["mdp"])) {
    echo "<form method='post' id='DC'>";
    echo "<input type='submit' name='Deco' value='Déconnexion'/>";
    if (!empty($_POST['Deco'])) {
      session_destroy();
      header("Refresh: 0");
    }
    echo "</form>";
    echo "<a id='profil' href='profil.php'> Profil </a>";
  }
?>
        <br/>
        <br/>
      </header>
    </div>
    
    
   <div id='page'>
<?php
  ini_set("display_errors", 1);
  if (isset($_POST['categories'])) {
    $categories = $_POST['categories'];
    if ($categories != 'Aucun') {
      recherche_base($categories);
    } else if ($categories = 'Aucun') {
      print_base();
    }
  } else if (isset($_POST['recherche'])) {
    $recherche = $_POST['recherche'];
    recherche_titre($recherche);
  } else  {
  print_base();
}
?>
    </div> 
    <footer id="footer">
      <a id='mentions' href ='mentions.php#mentions'> Mentions légales</a>
      <a id='droits' href ='mentions.php#droits'> Droits </a>
    </footer>
  </body>
</html>
