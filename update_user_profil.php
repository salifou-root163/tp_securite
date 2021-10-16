<?php 
include 'inc/header.php'; 
$id_utilisateur = $_SESSION['id_utilisateur'];
$requete="SELECT mot_de_passe_utilisateur, nom_utilisateur, prenom_utilisateur, login_utilisateur, telephone_utilisateur, email_utilisateur, description_utilisateur, photo_profil, adresse_utilisateur from utilisateur where id_utilisateur ='$id_utilisateur'";
$query=mysqli_query($bdd,$requete);
//echo mysqli_error($bdd);
$reponse=mysqli_fetch_array($query); 


?>

<div class="container" >
    <div class="row">
    
        <div class="col" >
            <?php  
            if ($reponse['photo_profil']==""){
                ?> <img id="profil_img" src="public/images/user.jpg" alt=""> <?php
            }else{
                echo '<img id='."profil_img".' src="data:image/jpeg;base64,'.base64_encode( $reponse['photo_profil'] ).'"/>'; 
                }
            ?>
        
            <br>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Modifier la photo de profil
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modification de la photo de profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                    <?php  
                    if ($reponse['photo_profil']==""){
                        ?> <img id="profil_img_modal" src="public/images/user.jpg" alt=""> <?php
                    }else{
                        echo '<img id='."profil_img_modal".' src="data:image/jpeg;base64,'.base64_encode( $reponse['photo_profil'] ).'"/>'; 
                        }
                    ?>
                    </div>
                    <br>
                    <form action="" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <input type="file" class="form-control" name="photo_profil" >
                        </div>
                        <br>
                        <div class="form-group">
                            <button type="submit" class="btn col-md-12  btn-primary" name="valider" id="btn-login">
                                ENREGISTRER
                            </button> 
                        </div>
                        

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    
                </div>
                </div>
            </div>
            </div>
            <br><br>
            <?php
                if (isset($_POST['valider'])){
                    
                    $id_utilisateur=$_SESSION['id_utilisateur'];
                    $taille_maxi = 1000000;
                    $extensions = array('.png', '.jpg', '.jpeg','.PNG', '.JPG', '.JPEG');
                    $fichier="metaimage.jpg";
                            
                    if(!empty(basename($_FILES['photo_profil']['name']))){
                    $fichier = basename($_FILES['photo_profil']['name']);
                    
                    $taille=$_FILES['photo_profil']['size'];        
                    
                    $extension = strrchr($_FILES['photo_profil']['name'], '.');
                    if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
                    {
                    $errors[]='Votre photo de profil doit etre de type png,  jpg, jpeg';
                    }
                    if($taille>$taille_maxi)
                    {
                    $errors[]="La taille de votre photo de profil doit etre inférieur ou égale à 1 mo";
                    }
                    if ($photo  = $_FILES['photo_profil']['tmp_name'] )            
                    {
                    $photo_profil=addslashes(file_get_contents($photo));
                    }else{
                        $errors[]="Votre photo n'a pas pu être télécharger !";    
                    }

                    }else{
                        $errors[]="Aucune image n'a été sélestionnée !";
                    }

                    if (!empty($errors)){

                        foreach($errors as $error){
                        
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                            echo "<strong>Erreur! </strong>".$error;
                            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                            echo "</div>";
                        }

                    }else{
                        $requete="Update utilisateur set photo_profil = '$photo_profil' where id_utilisateur = '$id_utilisateur'";
                        if(mysqli_query($bdd,$requete)){

                            ?>
                            <script > 
                            swal({
                                title: "Modification de la photo de profil.",
                                text: "Votre photo de profil à été modifiée avec succès. " ,
                                icon: "success",
                                button: "OK",
                                }).then(function(){
                                    window.location="update_user_profil.php";
                                    });
                            </script>
                            <?php

                        }else{
                            ?>
                            <script > 
                            swal({
                                title: "Modification de la photo de profil.",
                                text: "Erreur lors de la modification de la photo de profil. " ,
                                icon: "error",
                                button: "OK",
                                }).then(function(){
                                    window.location="update_user_profil.php";
                                    });
                            </script>
                            <?php
                        }
                    }


                }
            ?>

        </div>
        <div class="col">
            <form action="" method="POST">
                <div class="form-group">
                    <textarea name="description" class="form-control" name="" id="" Maxlength="250" cols="80" rows="8"><?php echo $reponse['description_utilisateur']; ?></textarea>
                </div> 
                <br>
                <div class="form-group">
                    <button type="submit" class="btn col-md-12  btn-primary" name="valider_description" id="btn-login">
                        ENREGISTRER LA MODIFICATION
                    </button> 
                </div>               
            </form>
            <?php
                if (isset($_POST['valider_description'])){
                    $description = mysqli_real_escape_string($bdd,$_POST['description']);
                    mysqli_query($bdd,"UPDATE utilisateur set description_utilisateur ='$description' where id_utilisateur = '$id_utilisateur' ");
                    ?>
                    <script>
                        window.location="update_user_profil.php";
                    </script>
                    <?php
                } 
            ?>
        </div>
    </div>

    <div class="container homeContainer">
        <h1>Mes informations personnelles   </h1>
        <hr>    
    </div>
    <div class="row" >
        <div class="col">
            <form action="" method="POST">
                 <div class="form-group">
                    <label class="col-form-label">identifiant <label class="star">*</label></label>
                    <input type="text" class="form-control" value='<?php echo @$reponse['login_utilisateur'];?>'  name="login" required />
                </div>
                <div class="form-group">
                    <label class="col-form-label">Nom <label class="star">*</label></label>
                    <input type="text" class="form-control" value='<?php echo @$reponse['nom_utilisateur'];?>'  name="nom" required />
                </div>
                <div class="form-group">
                    <label class="col-form-label">Prénom <label class="star">*</label></label>
                    <input type="text" class="form-control" value='<?php echo @$reponse['prenom_utilisateur'];?>' name="prenom" required />
                </div>
                <div class="form-group">
                    <label class="col-form-label">Adresse <label class="star">*</label></label>
                    <input type="text" class="form-control" value='<?php echo @$reponse['adresse_utilisateur'];?>'  name="adresse" required />
                </div>
                <div class="form-group">
                    <label class="col-form-label">Téléphone <label class="star">*</label></label>
                    <input type="text" class="form-control" value='<?php echo @$reponse['telephone_utilisateur'];?>'  name="telephone" required />
                </div>
                <div class="form-group">
                    <label class="col-form-label">Courriel <label class="star">*</label></label>
                    <input type="text" class="form-control" value='<?php echo @$reponse['email_utilisateur'];?>'  name="mail" required />
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn col-md-12 col-sm-12 col-xs-12 btn-primary" name="valider_info_personnelles" id="btn-login">
                        ENREGISTRER
                    </button> 
			    </div>
            </form>
            <?php
            if (isset($_POST['valider_info_personnelles'])){

                if(strlen($_POST['nom'])>0 && strlen($_POST['prenom'])>0 && strlen($_POST['adresse'])>0 && strlen($_POST['telephone'])>0 && strlen($_POST['mail'])>0 ){
                }else{
                    $errors[]="Veuillez renseigner tous les champs!";
                } 

                    $login =mysqli_real_escape_string($bdd,$_POST['login']); 
					$nom =mysqli_real_escape_string($bdd,$_POST['nom']);
					$prenom =mysqli_real_escape_string($bdd,$_POST['prenom']);
					$telephone =mysqli_real_escape_string($bdd,$_POST['telephone']); 
					$email =mysqli_real_escape_string($bdd,$_POST['mail']);
                    $adresse =mysqli_real_escape_string($bdd,$_POST['adresse']);

                //verifier si le mail n'est pas deja utilisé

                $requete=mysqli_query($bdd,"SELECT * from utilisateur where email_utilisateur = '$email' and statut_utilisateur ='1' and id_utilisateur <> '$id_utilisateur' ");
                $reponse=mysqli_num_rows($requete);
                if ($reponse>0){
                    $errors[]="Cette adresse mail est déja utilisée par un autre utilisateur";
                }

                //Verifier si le login n'est pas deja utilisé

                $requete=mysqli_query($bdd,"SELECT * from utilisateur where login_utilisateur = '$login' and statut_utilisateur ='1' and id_utilisateur <> '$id_utilisateur' ");
                $reponse=mysqli_num_rows($requete);
                if ($reponse>0){
                    $errors[]="Cet identifiant est déja utilisé par un autre utilisateur";
                }
                
                if(!filter_var($email,FILTER_VALIDATE_EMAIL))
                {
                    $errors[]="Veuillez utiliser un bon format d'adresse mail.";			
                }	
                                	
                if (!is_numeric($telephone))
                {
                    $errors[] = 'Format du numero de téléphone incorrect';
                }

                

                if(!empty($errors)){

                    foreach($errors as $error){
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                        echo "<strong>Erreur! </strong>".$error;
                        echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                        echo "</div>";
                    }
                }else{

                    if(mysqli_query($bdd,"UPDATE utilisateur set login_utilisateur = '$login', nom_utilisateur='$nom', prenom_utilisateur= '$prenom', adresse_utilisateur='$adresse', email_utilisateur='$email', telephone_utilisateur='$telephone' where id_utilisateur ='$id_utilisateur' ")){

                        ?>
                        <script >
                            swal({
                                title: "Modification des informations personnelles.",
                                text: "Modification effectuée avec succès! " ,
                                icon: "success",
                                button: "OK",
                            }).then(function(){
                                window.location="update_user_profil.php";
                            });
                        </script>
                        <?php 

                    }else{
                        
                        ?>
                        <script >
                            swal({
                                title: "Modification des informations personnelles.",
                                text: "Erreur lors de la modification des informations. " ,
                                icon: "error",
                                button: "OK",
                            }).then(function(){
                                window.location="update_user_profil.php";
                            });
                        </script>
                        <?php 

                    }
                }

            }
            ?>
        </div>
        <div class="col" >
            <form action="" method="POST">

                <div class="form-group">
                    <label class="col-form-label">Ancien mot de passe <label class="star">*</label> </label>
                    <input type="password" class="form-control"   name="ancien_pass" required />
                </div>
                <div class="form-group">
                    <label class="col-form-label">Nouveau mot de passe <label class="star">*</label></label>
                    <input type="password" class="form-control"  name="pass1" required />
                </div>
                <div class="form-group">
                    <label class="col-form-label">Confirmation du mot de passe <label class="star">*</label></label>
                    <input type="password" class="form-control"   name="pass2" required />
                </div>
                
                <br>
                <div class="form-group">
                    <button type="submit" class="btn col-md-12 col-sm-12 col-xs-12 btn-primary" name="valider_modification_password" id="btn-login">
                        ENREGISTRER
                    </button> 
			    </div>
            </form>
            <br>
            <?php 
                if (isset($_POST['valider_modification_password'])){
                    
                    if(strlen($_POST['ancien_pass'])>0 && strlen($_POST['pass1'])>0 && strlen($_POST['pass1'])>0 ){
                    }else{
                        $errors[]="Veuillez renseigner tous les champs!";
                    }

                    $ancien_pass=md5(mysqli_real_escape_string($bdd,$_POST['ancien_pass']));
                    $pass1=md5(mysqli_real_escape_string($bdd,$_POST['pass1']));
                    $pass2=md5(mysqli_real_escape_string($bdd,$_POST['pass2']));
                    
                    if ($ancien_pass<>$reponse['mot_de_passe_utilisateur']){
                        $errors[]="L'ancien mot de passe est incorrect!";
                    }

                    if ($pass1<>$pass2){
                        $errors[]="Les deux mots de passe ne correspondent pas!";
                    }

                    if(!empty($errors)){

                        foreach($errors as $error){
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                            echo "<strong>Erreur! </strong>".$error;
                            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                            echo "</div>";
                        }

                    }else{
                        if(mysqli_query($bdd,"UPDATE utilisateur set mot_de_passe_utilisateur = '$pass1' where id_utilisateur ='$id_utilisateur' ")){

                            ?>
                            <script >
                                swal({
                                    title: "Modification de mot de passe.",
                                    text: "Modification effectuée avec succès! Veuillez vous reconnecter pour continuer. " ,
                                    icon: "success",
                                    button: "OK",
                                }).then(function(){
                                    window.location="logout.php";
                                });
                            </script>
                            <?php

                        }else{
                            ?>
                            <script >
                                swal({
                                    title: "Modification de mot de passe.",
                                    text: "Erreur lors de la modification du mot de passe. " ,
                                    icon: "error",
                                    button: "OK",
                                }).then(function(){
                                    window.location="update_user_profil.php";
                                });
                            </script>
                            <?php
                        }

                    }

                    
                }
                
                
            
            ?>

        </div>
    </div>

    






</div>




<?php include 'inc/footer.php'; ?>