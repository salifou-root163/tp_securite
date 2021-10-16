<?php 
include 'inc/header.php'; 
$id_utilisateur = $_SESSION['id_utilisateur'];

$requete =mysqli_query($bdd,"SELECT * from utilisateur where id_utilisateur <> '$id_utilisateur' and statut_utilisateur ='1'");





?>
<div class="container">
    <table class="table table-sm">
        <tr>
            <th>Utilisateurs</th>
            <th>Actions</th>
        </tr>
       
        <tbody>
            <?php while($reponse=mysqli_fetch_array($requete)){
                $id_ami=$reponse['id_utilisateur'];
                $sous_requete=mysqli_query($bdd,"SELECT statut_demande from demande_ami where id_utilisateur='$id_utilisateur' and id_ami='$id_ami'");
                $reponse_sous_requete=mysqli_fetch_array($sous_requete);
                 ?>
            <tr>
                <td>
                    <?php 
                    if ($reponse['photo_profil']==""){
                        ?> 
                        <img class="user_profil" src="public/images/user.jpg" alt="Profil">
                        <?php
                    }else{
                        echo '<img class='."user_profil".' src="data:image/jpeg;base64,'.base64_encode( $reponse['photo_profil'] ).'"/>'; 
                        };
                    echo $reponse['nom_utilisateur']." ".$reponse['prenom_utilisateur'];                    

                    ?>
                </td>
                <td>
                    <?php
                    if ($reponse_sous_requete['statut_demande']==""){

                       
                        echo '<form action='."users.php".' method='."POST".'>';
                        echo '<input type='."hidden".' name='."id_ami_form".' value='."$id_ami".'>';
                        echo '<div class='."form-group".'>';
                        echo '<button type='."submit".' style='."background:cyan".' name='."demande_ami".' id='."btn-login".'>';
                        echo 'Envoyer une  demande';
                        echo '</button>';
                        echo '</div>';
                        echo '</form> ';

                    }
                    if($reponse_sous_requete['statut_demande']==1){

                        echo '<label style='."background:green".'> Ami(e) </label>';
                    }
                    if($reponse_sous_requete['statut_demande']==2){

                        echo "Demande en attente";
                        echo " ";
                        echo '<form action='."users.php".' method='."POST".'>';
                        echo '<input type='."hidden".' name='."id_ami_form".' value='."$id_ami".'>';
                        echo '<div class='."form-group".'>';
                        echo '<button type='."submit".' style='."background:red".' name='."annuler_demande_ami".' id='."btn-login".'>';
                        echo 'Annuler la demande';
                        echo '</button>';
                        echo '</div>';
                        echo '</form> ';
                    }
                    if ($reponse_sous_requete['statut_demande']==3){

                        echo '<label style='."background:red".'>Demande rejetée</label> ';
                        echo '<form action='."users.php".' method='."POST".'>';
                        echo '<div class='."form-group".'>';
                        echo '<button type='."submit".' style='."background:blue".' name='."nouvelle_demande_ami".' id='."btn-login".'>';
                        echo 'Envoyer une nouvelle demande';
                        echo '</button>';
                        echo '</div>';
                        echo '</form> ';
                    }
                    ?>
                </td>
            </tr>
            <?php } ?>

        </tbody>
    </table>

    <?php
    //demande d'amitier
    if (isset($_POST['demande_ami'])){
        $id_ami_form=$_POST['id_ami_form'];

        $requete_demande_ami="INSERT into demande_ami(id_utilisateur, id_ami, date_demande_ami, statut_demande ) values('$id_utilisateur','$id_ami_form',now(),'2')";
        if(mysqli_query($bdd,$requete_demande_ami)){

            $email=$reponse['email_utilisateur'];
            $nom=$reponse['nom_utilisateur'];
            $prenom=$reponse['prenom_utilisateur'];

            $to=$email;            
            $subject  = 'Demande d amitié.';
            $headers = "From: torkent163@gmail.com";            
            $message="Bonjour monsieur ".$nom." ".$prenom." \n 
            Vous venez de recevoir une demande d'amitié, 
            Veuillez vous connecter pour y repondre.";
            

            mail($to,$subject,$message, $headers);            

            ?>
            <script > 
            swal({
                title: "Demande d'ami.",
                text: "Demande éffectuée avec succès. " ,
                icon: "success",
                button: "OK",
                }).then(function(){
                    window.location="users.php";
                    });
            </script>
            <?php

        }else{
            ?>
            <script > 
            swal({
                title: "Demande d'ami.",
                text: "Erreur lors de la demande d'ami, veuillez rééssayer. " ,
                icon: "error",
                button: "OK",
                }).then(function(){
                    window.location="users.php";
                    });
            </script>
            <?php
        }

    }
    //FIn demande amitier

    //annulation de demande d'amitier
    if (isset($_POST['annuler_demande_ami'])){
        $id_ami_form=$_POST['id_ami_form'];

        $requete_annuler_demande_ami="DELETE from demande_ami where id_utilisateur ='$id_utilisateur' and id_ami='$id_ami_form'";
        if(mysqli_query($bdd,$requete_annuler_demande_ami)){

            ?>
            <script > 
            swal({
                title: "Demande d'ami.",
                text: "Demande annulée avec succès. " ,
                icon: "success",
                button: "OK",
                }).then(function(){
                    window.location="users.php";
                    });
            </script>
            <?php

        }else{
            ?>
            <script > 
            swal({
                title: "Demande d'ami.",
                text: "Erreur lors de l'annulation de la demande d'ami, veuillez rééssayer. " ,
                icon: "error",
                button: "OK",
                }).then(function(){
                    window.location="users.php";
                    });
            </script>
            <?php
        }

    }
    //fin de l'annulation de la demande

    //envoyer une nouvelle demande d'ami
    if (isset($_POST['nouvelle_demande_ami'])){
        $id_ami_form=$_POST['id_ami_form'];
        
        $requete_nouvelle_demande_ami="UPDATE demande_ami set statut_demande ='2' where id_utilisateur='$id_utilisateur' and id_ami='$id_ami_form')";
        if(mysqli_query($bdd,$requete_nouvelle_demande_ami)){

            $to=$reponse['email_utilisateur'];
            $nom=$reponse['nom_utilisateur'];
            $prenom=$reponse['prenom_utilisateur'];
            $subject  = 'Demande d amitié.';
            $headers = "From: torkent163@gmail.com";
            
            $message="Bonjour monsieur ".$nom." ".$prenom." \n 
            Vous venez de recevoir une demande d'amitié, 
            Veuillez vous connecter pour y repondre.";
            

            mail($to,$subject,$message, $headers);

            ?>
            <script > 
            swal({
                title: "Demande d'ami.",
                text: "Demande éffectuée avec succès. " ,
                icon: "success",
                button: "OK",
                }).then(function(){
                    window.location="users.php";
                    });
            </script>
            <?php

        }else{
            ?>
            <script > 
            swal({
                title: "Demande d'ami.",
                text: "Erreur lors de la demande d'ami, veuillez rééssayer. " ,
                icon: "error",
                button: "OK",
                }).then(function(){
                    window.location="users.php";
                    });
            </script>
            <?php
        }

    }
    //fin de l'envoi d'une nouvelle demande d'ami
    ?>
    

    

</div>


<?php include 'inc/footer.php'; ?>