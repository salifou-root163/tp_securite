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
    <h1>Réinitialisation de mot de passe</h1>
    <hr>    
  </div>
    <?php
    $token_recup=$_GET['confirm'];
    $req=mysqli_query($bdd,"SELECT * from utilisateur where token_mot_de_passe_oublier='$token_recup'");
    $rep=mysqli_fetch_array($req);
    if(!empty($rep)){

    ?>
    <div class="container">
        <form method="POST" action="">
            <input type="hidden" value="<?php echo $rep['id_utilisateur']; ?>" name="id_utilisateur">
            <div class="form-group">
                <label >Saisir votre nouveau mot de passe   *</label>
                <input type="password" class="form-control"  value="<?php echo @$_POST['pass1'];?>"  name="pass1" required />
            </div>
            <div class="form-group">
                <label >Confirmer votre nouveau mot de passe   *</label>
                <input type="password" class="form-control"  value="<?php echo @$_POST['pass2'];?>"  name="pass2" required />
            </div>

            <br/>
            <div class="form-group">
                <button type="submit" class="btn col-md-12 col-sm-12 col-xs-12 btn-primary" name="update" id="btn-login">
                    <i class="glyphicon glyphicon-edit"></i> &nbsp; Réinitialiser le mot de passe
                </button>
            </div>
        </form>
        <br>    
        
    <?php

    }else{
        ?>
        <script >
            swal({
                title: "Récupération de mot de passe.",
                text: "Erreur le lien de récupération est incorrect ou à déja eté utiliser. " ,
                icon: "error",
                button: "OK",
            }).then(function(){
                window.location="index.php";
            });
        </script>
        <?php
    }


    if (isset($_POST['update'])){

        $mot_passe_1=md5($_POST['pass1']);
        $mot_passe_2=md5($_POST['pass2']);

        if ($mot_passe_1 == $mot_passe_2){

            $id_utilisateur=$_POST['id_utilisateur'];
            if (mysqli_query($bdd,"UPDATE utilisateur set mot_de_passe_utilisateur='$mot_passe_1' WHERE id_utilisateur='$id_utilisateur'")){

                $update_token=mysqli_query($bdd,"UPDATE utilisateur set token_mot_de_passe_oublier='null' where id_utilisateur ='$id_utilisateur' ");


                ?>
                <script >
                    swal({
                        title: "Réinitialisation de mot de passe.",
                        text: "Mot de passe réinitialisé avec succès.Veuillez vous connecter pour continuer. " ,
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
                        title: "Céation de mot de passe.",
                        text: "Erreur lors de la réinitialisation du mot de passe.Veuillez rééssayer.",
                        icon: "error",
                        button: "OK",
                    });
                </script>
                <?php

            }

        }else{
            echo "<div class='alert alert-danger'><b>Erreur </b>:Les deux mot de passe ne correspondent pas.</div>";
        }

    }
    ?>
    </div>

<?php require 'inc/footer.php'; ?>	


