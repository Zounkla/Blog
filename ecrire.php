<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>Ecrire un article</title>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="ecrire.css"/>
  </head>
  
  <body>
    <h1>Ecrire un article</h1>
    <form action="ecrire.php" method="post">
      <p id="title">
        Titre : <input type = "text" name="title" maxlength="25" size="25"/>
      </p>
      <p id="text">
        <textarea  name="texte" placeholder="Ecrire ici" rows="50" cols="200" 
        maxlength="4294967296" spellcheck="true"></textarea>
      </p>
      <select name="categories">
        <option value="Aucun">Aucun</option>
        <option value="PC">PC</option>
        <option value="PS">PlayStation</option>
      </select>
      
      <p id="send">
        <input type="submit" value="Envoyer"/>
      </p>
      <?php
        ini_set('display_errors', 1);
        if (isset($_POST['title']) && isset($_POST['texte'])
            && isset($_POST['categories'])) {
          if (empty($_POST['title']) || empty($_POST['texte'])) {
            echo "champ(s) vide(s)";
          } else {
            $date = date("Y/m/d");
            $categories = $_POST['categories'];
            include ('connect_login.php');
            $title = htmlentities($_POST['title'], ENT_QUOTES);
            $texte = htmlentities($_POST['texte'], ENT_QUOTES);
            $requete = "INSERT INTO articles(titre, texte, date, categorie) 
                        VALUES('$title', '$texte', '$date','$categories')";
            $res = mysqli_query($connexion, $requete);
            $j = mysqli_error($connexion);
            if ($j != NULL) {
              echo "Erreur !";
            } else if ($j == NULL) {
              echo "Article bien écrit\n";
              echo "<br/>";
              echo "<a href='accueil.php'>Retour à l'accueil</a>";
            }
            mysqli_close($connexion);
          }
        }
      ?>
    </form>
    <a href='accueil.php'>Ne rien écrire</a>
    <br/>
    <br/>
    <footer id="footer">
      <a id='mentions' href ='mentions.php#mentions'> Mentions légales</a>
      <a id='droits' href ='mentions.php#droits'> Droits </a>
    </footer>
  </body>
</html>
