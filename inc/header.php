<?php
include 'bdd.php';

if (empty($_SESSION['id_utilisateur'])){
    header('location:index.php');
  }
  $id_utilisateur = $_SESSION['id_utilisateur'];
  $requete=mysqli_query($bdd,"SELECT nom_utilisateur , prenom_utilisateur , photo_profil from utilisateur where id_utilisateur ='$id_utilisateur'");
  $reponse=mysqli_fetch_array($requete);
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

  
  <!-- Bootstrap CSS -->
  <link href="public/css/bootstrap.min.css" rel="stylesheet" >
  
  <script src="public/js/jquery.min.js"></script>
  <script src="public/js/bootstrap.min.js" ></script>
  <script src="public/js/sweetalert.min.js"></script>

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
</head>

<body class="d-flex flex-column h-100">

  <header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="accueil.php">Security Event</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="accueil.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user_profil.php">Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="gallerie.php">Gallerie</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="users.php">Utilisateurs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="friends.php">Amis</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="friend_request.php">Mes demandes d'amitié</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="posts.php">Forum</a>
            </li>
          </ul>
          <form action="user_profil.php" method="POST" class="d-flex">
            <button class="btn btn-outline-success" type="submit">
            <?php echo '<img class='."user_profil".' src="data:image/jpeg;base64,'.base64_encode( $reponse['photo_profil'] ).'"/>'." ".$reponse['nom_utilisateur']." ".$reponse['prenom_utilisateur'] ; ?>
            </button>
          </form>
        </div>
      </div>
    </nav>
  </header>
  <div class="d-flex flex-row-reverse bd-highlight loginEtLogout" style="margin-top: 20px;">
    <div class="p-2 bd-highlight"><a class="btn btn-outline-dark" href="logout.php" role="button">Déconnexion</a> </div>
    

  </div>
  <main class="flex-shrink-0">