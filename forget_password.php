<?php
	include 'bdd.php';
	include 'inc/function.php';
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
  
    <div class="p-2 bd-highlight"><a class="btn btn-outline-dark" href="index.php" role="button">Connexion</a> </div>

  </div>
  <main class="flex-shrink-0">
  <div class="container homeContainer">
    <h1>Récupération de mot de passe</h1>
    <hr>    
  </div>
            
    <div class="container">
    <form method="POST" action="">
        <div class="form-group">
            <label class="col-form-label">Saisir votre adresse Mail *</label>
            <input type="text" class="form-control" Maxlength="250" value="<?php echo @$_POST['mail'];?>"  name="mail" required />
        </div>

        <br/>
        <div class="form-group">
            <button type="submit" class="btn col-md-12 col-sm-12 col-xs-12 btn-primary" name="connect" id="btn-login">
                <i class="glyphicon glyphicon-edit"></i> &nbsp; Envoyer le code de récupération
            </button>
        </div>
        <br>
        <?php
            if(isset($_POST['connect'])){
                if (strlen($_POST['mail'])>0){  
                  
                  $recup_mail=$_POST['mail'];
                  $req=mysqli_query($bdd,"SELECT * from utilisateur where email_utilisateur = '$recup_mail'");
                  $rep=mysqli_fetch_array($req);

                  $nbr_ligne=mysqli_num_rows($req);
                  if($rep>0){

                      $to=$recup_mail;
                      $subject  = 'Récupération de mot de passe.';
                      $headers = "From: site@gmail.com";
                      $token=md5(token(30));
                      $id_utilisateur=$rep['id_utilisateur'];
                      $lien="site/reset_password.php?confirm=".$token."";
                      //echo $message;
                      $message="Bonjour monsieur ".$rep['nom_utilisateur']." ".$rep['prenom_utilisateur']." \n Vous avez fait une requete de changement de mot de passe.\nVeuillez cliquer sur ce lien pour changer votre mot de passe.\n ".$lien."\nSi cette requete ne vient pas de vous, veuillez ignorer ce mail.";
                      if (mail($to,$subject,$message, $headers)){

                          $update_token=mysqli_query($bdd,"UPDATE utilisateur set token_mot_de_passe_oublier='$token' where id_utilisateur ='$id_utilisateur' ");

                          ?>

                          <script >
                              swal({
                                  title: "Récupération de mot de passe.",
                                  text: "Nous venons de vous envoyé des instructions par mail pour reinitialiser votre mot de passe. " ,
                                  icon: "success",
                                  button: "OK",
                              }).then(function(){
                                  window.location="index.php";
                              });
                          </script>
                      <?php

                      }else{
                      
                      ?>
                          <script >
                              swal({
                                  title: "Récupération de mot de passe.",
                                  text: "Erreur lors de l'envoi du mail.Veuillez rééssayer. " ,
                                  icon: "error",
                                  button: "OK",
                              }).then(function(){
                                  window.location="forget_password.php";
                              });
                          </script>
                          <?php

                      }


                  }else{
                    
                      echo"<div class='alert alert-danger'><b>Erreur </b>:Cette adresse est inconnue.</div>";
                  }
                }else{
                  echo"<div class='alert alert-danger'><b>Erreur </b>:Veuillez saisir une adresse mail.</div>";
                }
            }
            ?>
        
        
    </form>
    </div>
    <?php require 'inc/footer.php'; ?>


