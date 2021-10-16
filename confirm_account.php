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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">



  <!-- Bootstrap core CSS -->
  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <h1>Vérification de compte</h1>
    <hr>    
  </div>
  <div class="container">
   <form method="POST" action="" id="login-form" autocomplete="off">
        <div class="form-group">
            <label for="login_user" class="col-form-label">Adresse mail *</label>
            <input type="mail" value="<?php echo @$_POST['email']; ?>" placeholder="Entrez votre adresse mail" maxlength="100"  <?php if(isset($_POST['email']) and strlen($_POST['email'])>0){ echo '';}{ echo "autofocus"; }?> class="form-control" name="email" required />
        </div>
        <div class="form-group">
            <label for="pass_user" class="col-form-label">Code de confirmation *</label>
            <input type="text"  class="form-control"  placeholder="Entrez votre code de confirmation" name="code_confirmation" required />
        </div>
        <div class="row">
            <div  class="col-md-12 col-sm-12 col-xs-12"><br>
                <div class="form-group">
                    <button class="btn col-md-12 col-sm-12 col-xs-12 btn-primary" name="verifier" id="btn-login">
                         Activer
                    </button>
                </div>
            </div>
        </div>
        <?php 

            if (isset($_POST['verifier'])){
                $mail_utilisateur =mysqli_real_escape_string($bdd, $_POST['email']);
                $code_confirmation_utilisateur=mysqli_real_escape_string($bdd, $_POST['code_confirmation']);
                
                
                
                $requete="SELECT * from utilisateur where email_utilisateur='$mail_utilisateur' and code_confirmation_utilisateur ='$code_confirmation_utilisateur' ";
                $query=mysqli_query($bdd, $requete);
                //echo (mysqli_error($bdd));
                $reponse=mysqli_fetch_array($query);
                $id_utilisateur=$reponse['id_utilisateur'];

                
                if(mysqli_num_rows($query)>0){


                    if($reponse['statut_utilisateur'] == 0 ){

                        if (date("Y-m-d H:i:s")<$reponse['date_expiration_code_confirmation']){

                            
                            if(mysqli_query($bdd, "UPDATE utilisateur SET statut_utilisateur = 1 where id_utilisateur ='$id_utilisateur'")){

                                ?>
                                <script > 
                                swal({
                                    title: "Vérification de compte.",
                                    text: "Votre compte à été validé avec succès.cliquez sur OK pour continuer. ",
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
                                    title: "Vérification  de compte.",
                                    text: "Erreur lors de la vérification du compte.Veuillez rééssayer. " ,
                                    icon: "error",
                                    button: "OK",
                                    }).then(function(){
                                        window.location="activation.php";
                                        });
                                </script>
                                <?php
                                }//ici

                        }else{

                            //date expiré
                            // mise a jour du code de confirmation et de la date d'expiration
                            $code_confirmation_utilisateur=code(5);
                            $date = date("Y-m-d H:i:s");
                            $date=date('Y-m-d H:i:s', strtotime($date. ' + 3 days'));

                            mysqli_query($bdd,"UPDATE utilisateur SET code_confirmation_utilisateur ='$code_confirmation_utilisateur', date_expiration_code_confirmation='$date'  where id_utilisateur ='$id_utilisateur'");
                            echo mysqli_error($bdd);

                            //envoi du nouveau code de confirmation à l'utilisateur
                            $to=$reponse['email_utilisateur'];
                            $subject  = 'Validation de compte';
                            $headers = "From: torkent163@gmail.com";

                            
                            $lien="site/confirm_account.php";
                            //echo $message;
                            $message="Bonjour monsieur ".$reponse['nom_utilisateur']." ".$reponse['prenom_utilisateur']." \n Nous venons de vous renvoyer un nouveau code de confirmation.\nveuillez cliquer sur ce lien pour confirmer votre compte.\n".$lien."\nVotre LOGIN est: ".$reponse['login_utilisateur']."\nVotre code de confirmation est: ".$code_confirmation_utilisateur;
                            mail($to,$subject,$message, $headers);

                            ?>
                                <script > 
                                swal({
                                    title: "Vérification  de compte.",
                                    text: "La date de vérification est expirée! nous vous avons envoyer un nouveau code de confirmation mail.Veuillez l'utiliser avant trois jours. " ,
                                    icon: "warning",
                                    button: "OK",
                                    }).then(function(){
                                        window.location="confirm_account.php";
                                        });
                                </script>
                                <?php 
                        }
                    


                    }else{
                    ?>
                        <script> 
                        swal({
                            title: "Vérification de compte.",
                            text: "Ce compte à déjà été activé. " ,
                            icon: "warning",
                            button: "OK",
                            }).then(function(){
                                window.location="index.php";
                                });
                        </script>
                        <?php

                    }

                }else{
                    ?>
                    <script> 
                    swal({
                        title: "Vérification de compte.",
                        text: "Code de vérification ou adresse mail invalide. ",
                        icon: "error",
                        button: "OK",
                        });
                    </script>
                    <?php
                }


            }
                
            ?>
 </form>
 </div>
 
<?php require 'inc/footer.php'; ?>
 

