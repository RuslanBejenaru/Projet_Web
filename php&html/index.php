<?php
  session_start();
  // Récupérer les données de votre fichier JSON
  $json_file = file_get_contents("../json/etudiant.json");
  $data = json_decode($json_file, true);

  // Vérifier si le formulaire est soumis
  if(isset($_POST['email']) && isset($_POST['mdp'])){
    $pseudo = $_POST['email'];
    $mdp = $_POST['mdp'];
    $fonction = $_POST['fonction'];
    $semaine = 1;
 
    // Vérifier si l'utilisateur existe dans le fichier JSON
    foreach($data[$fonction] as $utilisateur){
      if($utilisateur['mail'] == $pseudo && $utilisateur['mdp'] == $mdp){
        // L'utilisateur est authentifié, afficher le calendrier
        $_SESSION ["loggedin"]=true;
        $_SESSION ["loggein"]=$pseudo;
        $_SESSION ["sem"] = 1;
        if ($fonction == "enseignant") {
          header('Location: enseignant.php');
        }
        else if ($fonction == "etudiant") {
          header('Location:etudiant.php');
        }
        else if ($fonction == "admin") {
          header('Location:mediation.html');
        }
        exit;
      }
    }
    // Si l'utilisateur n'existe pas ou les informations de connexion sont incorrectes, afficher un message d'erreur
    echo "Pseudo ou mot de passe incorrect";
  }
?>

<!DOCTYPE html>

<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login Platform</title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'><link rel="stylesheet" href="../css/style.css">
</head>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login Platform</title>
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'><link rel="stylesheet" href="./style.css">

</head>
<body>

<!-- Entete -->
<header>
  <div class="container">
  <img id="logo" src="../img/logotransparent.png" width="200px">
  <div id="titre_principale" > Authentification</div>
  <div></div>
  </div>
</header>

<!-- Notre formulaire -->
<div class="login-form">
  <form method="post">
    <!-- Titre -->
    <h1>Login :</h1>
    <div class="content">
      <!-- Input pour le mail de connexion -->
      <div class="input-field" id="email">
        <input type="email" placeholder="Saisissez votre email" autocomplete="nope" name='email' required>
      </div>
      <!-- Input pour le mot de passe -->
      <div class="input-field" id="mdp">
        <input type="password" placeholder="Saisissez votre mot de passe" autocomplete="new-password" name="mdp" required>
      </div>
      <!-- Input pour la fonction de l'utilisateur -->
      <div class="fonctions">
        <label for="fonctions">Saissez votre fonction : </label>
        <select class="input-field" id="fonction" name="fonction" required>
            <option value="etudiant">Etudiant</option>
            <option value="enseignant">Enseignant</option>
            <option value="admin">Administrateur</option>
        </select required>
      </div>
      <!-- Dans le cas où l'utilisateur a oublié son mdp mais ce sera optionnel dans le projet -->
      <a href="#" class="link">Mot de passe oublié ?</a>
    </div>
    <!-- Action possible -->
    <div class="action">
      <!-- Se connecter -->
      <input type="submit" id="connect"  value="Se connecter" >
      <!-- S'inscrire -->
      <!--<input type="submit" id="subscribe" value="S'inscrire" >-->
    </div>
  </form>
</div>
<!-- Fichier JavaScript -->
<script  src="../java/script.js"></script>

</body>
</html>
