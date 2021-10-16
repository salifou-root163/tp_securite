<?php 
include 'inc/header.php'; 
$id_utilisateur = $_SESSION['id_utilisateur'];

$requete =mysqli_query($bdd,"SELECT * from utilisateur u, liste_ami l where  u.id_utilisateur = l.id_ami and statut_utilisateur ='1' and l.id_utilisateur = '$id_utilisateur'");





?>
<div class="container">
    <table class="table table-sm">
        <tr>
            <th>Mes amis</th>
            
        </tr>
       
        <tbody>
            <?php while($reponse=mysqli_fetch_array($requete)){
                $id_ami=$reponse['id_ami'];
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
                    
                        echo " ";
                        echo '<form action='."friends.php".' method='."POST".'>';
                        echo '<input type='."hidden".' name='."id_ami_form".' value='."$id_ami".'>';
                        echo '<div class='."form-group".'>';
                        echo '<button type='."submit".' style='."background:red".' name='."annuler_demande_ami".' id='."btn-login".'>';
                        echo 'Retirer de mes amis';
                        echo '</button>';
                        echo '</div>';
                        echo '</form> ';
                    
                    
                    ?>
                </td>
            </tr>
            <?php } ?>

        </tbody>
    </table>

    <?php
    

    //annulation de demande d'amitier
    if (isset($_POST['annuler_demande_ami'])){
        $id_ami_form=$_POST['id_ami_form'];
        
        $requete_annuler_demande_ami="DELETE from demande_ami where id_utilisateur ='$id_ami_form' and id_ami='$id_utilisateur' ";

        $requete_annuler_demande_ami2="DELETE from liste_ami where id_utilisateur ='$id_utilisateur' and id_ami='$id_ami_form' ";

        if( mysqli_query($bdd,$requete_annuler_demande_ami) && mysqli_query($bdd,$requete_annuler_demande_ami2) ){

            ?>
            <script > 
            swal({
                title: "Suppression d'amitié.",
                text: "Suppression effectuée avec succès. " ,
                icon: "success",
                button: "OK",
                }).then(function(){
                    window.location="friends.php";
                    });
            </script>
            <?php

        }else{
            ?>
            <script > 
            swal({
                title: "Suppression d'amitié.",
                text: "Erreur lors de la suppression de la demande d'ami, veuillez rééssayer. " ,
                icon: "error",
                button: "OK",
                }).then(function(){
                    window.location="friends.php";
                    });
            </script>
            <?php
        }

    }
    //fin de l'annulation de la demande

    
    ?>
    

    

</div>


<?php include 'inc/footer.php'; ?>