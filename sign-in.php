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
    <h1>Inscription</h1>
    <hr>    
  </div>

	<div class="container">	
		<form method="POST" action=''>
			<div class="row">	
				<div class="col-md-6 ">			
					
					<div class="form-group">
						<label class="col-form-label">Identifiant *</label>
						<input type="text" class="form-control" value='<?php echo @$_POST['login'];?>' minlength=3 Maxlength="50" name="login" required />
					</div>
					<div class="form-group">
						<label class="col-form-label">Mot de passe *</label>
						<input type="password" class="form-control"  Maxlength="50" name="pass1" required />
					</div>
					<div class="form-group">
						<label class="col-form-label">Confirmation du mot de passe *</label>
						<input type="password" class="form-control"  Maxlength="50" name="pass2" required />
					</div>
					
					
				</div>
				<div class="col-md-6 ">
					<div class="form-group">
						<label class="col-form-label">Nom *</label>
						<input type="text" class="form-control" value='<?php echo @$_POST['nom'];?>' Maxlength="50" name="nom" required />
					</div>
					<div class="form-group">
						<label class="col-form-label">Prenom *</label>
						<input type="text" class="form-control" value='<?php echo @$_POST['prenom'];?>' Maxlength="50" name="prenom" required />
					</div>
					<div class="form-group">
						<label class="col-form-label">Téléphone *</label>
						<input type="tel" class="form-control" value='<?php echo @$_POST['telephone'];?>' minlength=8 required Maxlength="15"  name="telephone"  />
					</div> 						
				</div>

			</div>				
			
			<div class="form-group">
				<label class="col-form-label">Adresse email *</label>
				<input type="email" class="form-control" value='<?php echo @$_POST['email'];?>' minlength=5 Maxlength="50"  name="email" required />
			</div>
			<br>
			<div class="form-group">
				<button type="submit" class="btn col-md-12 col-sm-12 col-xs-12 btn-primary" name="valider" id="btn-login">
					ENREGISTRER
				</button> 
			</div>
			<br>
				<?php
				//
				if(isset($_POST['valider'])){  

					$login =mysqli_real_escape_string($bdd,$_POST['login']); 
					$nom =mysqli_real_escape_string($bdd,$_POST['nom']);
					$prenom =mysqli_real_escape_string($bdd,$_POST['prenom']);
					$telephone =mysqli_real_escape_string($bdd,$_POST['telephone']); 
					$email =mysqli_real_escape_string($bdd,$_POST['email']);
					$pass1 =md5(mysqli_real_escape_string($bdd,$_POST['pass1']));
					$pass2 =md5(mysqli_real_escape_string($bdd,$_POST['pass2']));

					
					if (strlen($login)>0 && strlen($nom)>0 && strlen($prenom)>0 && strlen($telephone)>0 && strlen($email)>0 && strlen($_POST['pass1'])>0 && strlen($_POST['pass2'])>0){					

					}else{
						$errors[]="Veuillez renseigner tous les champs.";
					}
					
					if(!empty($email)){
						if(!filter_var($email,FILTER_VALIDATE_EMAIL))
						{
							$errors[]="Veuillez utiliser un bon format d'adresse mail.";			
						}												
					}

					if(!empty($telephone)){		
						if (!is_numeric($telephone))
						{
							$errors[] = 'Format du numero de téléphone incorrect';
						}

					}

					if ($pass1<>$pass2)
					{
						$errors[] = 'Les deux mots de passe ne correspondent pas.';
					}

					
					if(!empty($errors)){		
						foreach($errors as $error){
							echo"<div class='alert alert-danger alert-dismissable'>".$error;								
							echo"</div>";
						}
					}
					else{
						//Ont vérifier si l'adresse email ne pas déja enregistré
						$query="SELECT * FROM utilisateur WHERE login_utilisateur = '$login'";
						$resulta=mysqli_query($bdd,$query);
						$rows =mysqli_num_rows($resulta);
						if($rows==0){
							$query="SELECT * FROM utilisateur WHERE email_utilisateur = '$email' and statut_utilisateur<>2";
							$resulta=mysqli_query($bdd,$query);
							$rows =mysqli_num_rows($resulta);
							if ($rows==0){

							$token_mot_de_passe_oublier=md5(token(25));
							$code_confirmation_utilisateur=code(5);
							$date = date("Y-m-d H:i:s");
							$date= date('Y-m-d H:i:s', strtotime($date. ' + 3 days'));
							
							//Insertion de l'utilisateur
							$insert_utilisateur="INSERT INTO utilisateur(nom_utilisateur,prenom_utilisateur,login_utilisateur,telephone_utilisateur,email_utilisateur,code_confirmation_utilisateur,date_ajout_utilisateur,token_mot_de_passe_oublier,statut_utilisateur,date_expiration_code_confirmation,mot_de_passe_utilisateur)VALUES('$nom','$prenom','$login','$telephone','$email','$code_confirmation_utilisateur',Now(),'$token_mot_de_passe_oublier',0,'$date','$pass1')";

							if( mysqli_query($bdd,$insert_utilisateur ) ){
								?>
								<script > 
								swal({
									title: "Création de compte.",
									text: "Utilisateur enregistré avec succès!Un mail avec les informations de connexion vient d'être envoyer au concerné. " ,
									icon: "success",
									button: "OK",
									}).then(function(){
										window.location="confirm_account.php";
										});
								</script>

								<?php
								//envoie de l'email de confirmation

								$to=$email;
								$subject  = 'Création de compte';
								$headers = "From: torkent163@gmail.com";
								$lien="site/confirm_account.php";
								$message="Bonjour monsieur ".$nom." ".$prenom." \n 
								Votre compte à bien eté créer.\n
								veuillez cliquer sur ce lien pour activer votre compte.\n"
								.$lien."\n
								Votre identifiant est: ".$login."\n
								Votre code de confirmation est: ".$code_confirmation_utilisateur;

								mail($to,$subject,$message, $headers);

								//renitialisation de varible
								$email ="";
								$nom ="";		
								$telephone ="";
								$login ="";
										
							}else{
								echo"<div class='alert alert-danger'>Opération non réussie.Veuillez réessayer</div>";
								}
							}else{
								echo"<div class='alert alert-danger'><b>ERREUR </b>: Le mail saisie est déjà utilisé par un autre utilisateur.</div>";
							}
						}else{
							echo"<div class='alert alert-danger'><b>ERREUR </b>: Le login saisie est déjà utilisé par un autre utilisateur.</div>";
						}
					}

				}

				?>
			
		</form>
	</div>

	<?php require 'inc/footer.php'; ?>
