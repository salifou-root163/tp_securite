<?php 
include 'inc/header.php'; 
$id_utilisateur = $_SESSION['id_utilisateur'];
$requete="SELECT mot_de_passe_utilisateur, nom_utilisateur, prenom_utilisateur, login_utilisateur, telephone_utilisateur, email_utilisateur, description_utilisateur, photo_profil from utilisateur where id_utilisateur ='$id_utilisateur'";
$query=mysqli_query($bdd,$requete);
//echo mysqli_error($bdd);
$reponse=mysqli_fetch_array($query); 


?>

<div class="container" >
      
        <div class="row">
            <div class="col col-md-4">
                <?php  
                if ($reponse['photo_profil']==""){
                    ?> <img id="profil_img" src="public/images/user.jpg" alt=""> <?php
                }else{
                    echo '<img id='."profil_img".' src="data:image/jpeg;base64,'.base64_encode( $reponse['photo_profil'] ).'"/>'; 
                    }
                ?> 
                
                <br>
                
                
            </div>
            <div class="col">
                    <h1 ><?php echo @$reponse['nom_utilisateur']; ?></h1>
                    <h2 ><?php echo @$reponse['prenom_utilisateur']; ?></h2>
                    <h2 ><?php echo @$reponse['email_utilisateur']; ?></h2>
                    <h2 ><?php echo @$reponse['telephone_utilisateur']; ?></h2>
                    <h2 ><?php echo @$reponse['adresse_utilisateur']; ?></h2>
            </div>

        </div>

        <u><label class="col-form-label">Description</label></u>

        <div class=" card container-fluid">
            
            <p class="text-break">
                <?php echo $reponse['description_utilisateur']; ?>
            </p> 
        </div> 
        <br>
        <center>
            <a href="update_user_profil.php"  class="btn btn-primary " >
            Modifier les information du profil
            </a>
        </center>
           
        
       
    </div>

    






</div>




<?php include 'inc/footer.php'; ?>