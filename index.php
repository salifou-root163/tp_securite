<?php
	include 'bdd.php';
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.87.0">
  <title>Security Test</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/carousel/">
  <!-- Bootstrap CSS -->
  
  <!-- Bootstrap core CSS -->
  <link href="public/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <link rel="stylesheet" href="public/css/styles.css">


  <!-- Custom styles for this template -->
  <link href="public/css/carousel.css" rel="stylesheet">
  <script src="public/js/sweetalert.min.js"></script>
</head>

<body class="d-flex flex-column h-100">

  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Security Event</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
      </div>
    </nav>
  </header>
  <div class="d-flex flex-row-reverse bd-highlight loginEtLogout" style="margin-top: 20px;">
  
    <div class="p-2 bd-highlight"><a class="btn btn-outline-dark" href="sign-in.php" role="button">Inscription</a> </div>

  </div>
  <main class="flex-shrink-0">
  <div class="container homeContainer">
    <h1>Connexion</h1>
    <hr>    
  </div>

  <div class="container">

    <form method="POST" class="col col-md-6" class="form-group " action="" id="login-form"  autocomplete="off">

          <div class="form-group">
              <label class=" col-form-label" for="login_user" >Nom d'utilisateur *</label><br>
              <input type="text" class="form-control" value="<?php echo @$_POST['login']; ?>" placeholder="Entrez votre nom d'utilisateur" maxlength="50" name="login" required />
          </div>
      
          <div class="form-group">
              <label class=" col-form-label" for="pass_user" >Mot de passe *</label><br>
              <input type="password" class="form-control" placeholder="Entrez votre mot de passe" name="motdepasse" required /> 
          </div>
      <br>	
      <button  name="valider" class="btn col-md-12 col-sm-12 col-xs-12 btn-primary" id="btn-login">&nbsp; Se connecter </button> <br><br>

      <a href="forget_password.php">Mot de passe oublié?</a>
          <br><br>
          
          <!--Début traitement -->
          <?php
          if(isset($_POST["valider"])){
              $login=mysqli_real_escape_string($bdd,$_POST["login"]);
              $motdepasse=mysqli_real_escape_string($bdd,$_POST["motdepasse"]);

              if(strlen($login)>0 && strlen($motdepasse)>0){

                  $motdepasse=md5($motdepasse);
                  $query="SELECT login_utilisateur, id_utilisateur, nom_utilisateur, prenom_utilisateur, statut_utilisateur FROM utilisateur WHERE login_utilisateur='$login' AND mot_de_passe_utilisateur='$motdepasse'";
                  $resulta=mysqli_query($bdd,$query);
                  $rows =mysqli_fetch_array($resulta);

                  if (mysqli_num_rows($resulta)>0){

                      if ($rows['statut_utilisateur']==0){
                          //le compte n'est pas encore activé
                          header('location:confirm_account.php');
                      }else if($rows['statut_utilisateur'] == 1) {
                          //le compte est actif
                          
                          $_SESSION['id_utilisateur']=$rows["id_utilisateur"];                     

                          header('location:accueil.php');

                      }else if ($rows['statut_utilisateur'] == 3 ){
                          //le compte a eté desactivé  (Par un administrateur)
                          echo "<div class='alert alert-danger'><b>Erreur </b>:Votre compte a été désactiver.</div>";

                      }else if ($rows['statut_utilisateur']== 2){
                          //le compte a eté supprimé (de façon logique)
                          echo "<div class='alert alert-danger'><b>Erreur </b>:Votre compte a été supprimé.</div>";

                      }else{

                          echo "<div class='alert alert-danger'><b>Erreur </b>:Identifiant ou mot de passe incorrect.</div>";
                      }

                  }else{

                      echo "<div class='alert alert-danger'><b>Erreur </b>:Identifiant ou mot de passe incorrect.</div>";
                  }
              }else{

                  echo"<div class='alert alert-danger'><b>Erreur </b>:Veuillez saisir tous les champs.</div>";
              }

          }


          ?>
          <!--Fin traitement -->

    </form>
  </div>

  <?php require 'inc/footer.php'; ?>
