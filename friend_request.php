<?php 
include 'inc/header.php'; 
$id_utilisateur = $_SESSION['id_utilisateur'];

$requete =mysqli_query($bdd,"SELECT * from utilisateur u, demande_ami d where  u.id_utilisateur = d.id_utilisateur and statut_utilisateur ='1' and d.id_ami = '$id_utilisateur' and statut_demande = 2");





?>
<div class="container">
    <table class="table table-sm">
        <tr>
            <th>Mes amis</th>
            
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
                    
                        echo " ";
                        echo '<form action='."friend_request.php".' method='."POST".'>';
                        echo '<input type='."hidden".' name='."id_ami_form".' value='."$id_ami".'>';
                        echo '<div class='."form-group".'>';
                        echo '<button type='."submit".' style='."background:red".' name='."refuser".' id='."btn-login".'>';
                        echo 'Refuser';
                        echo '</button>';
                        echo '</div>';
                        echo '</form> ';

                        echo " ";
                        echo '<form action='."friend_request.php".' method='."POST".'>';
                        echo '<input type='."hidden".' name='."id_ami_form".' value='."$id_ami".'>';
                        echo '<div class='."form-group".'>';
                        echo '<button type='."submit".' style='."background:green".' name='."accepter".' id='."btn-login".'>';
                        echo 'Accepter';
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
    

    // demande accepter
    if (isset($_POST['accepter'])){
        $id_ami_form=$_POST['id_ami_form'];
       

        $requete_accepter="UPDATE  demande_ami set statut_demande='1' where id_utilisateur ='$id_ami' and id_ami='$id_utilisateur'";
        $requete_accepter2="INSERT into  liste_ami (id_utilisateur, id_ami, date_ajout_ami) values ('$id_utilisateur','$id_ami',now())";
        if(mysqli_query($bdd,$requete_accepter) && mysqli_query($bdd,$requete_accepter2)){

            ?>
            <script > 
            swal({
                title: "Validation d'ami.",
                text: "Validation effectuée avec succès. " ,
                icon: "success",
                button: "OK",
                }).then(function(){
                    window.location="friend_request.php";
                    });
            </script>
            <?php

        }else{
            ?>
            <script > 
            swal({
                title: "Validation d'ami.",
                text: "Erreur lors de la validation de la demande d'ami, veuillez rééssayer. " ,
                icon: "error",
                button: "OK",
                }).then(function(){
                    window.location="friend_request.php";
                    });
            </script>
            <?php
        }

    }
    //fin demande accepter

    // demande accepter
    if (isset($_POST['refuser'])){
        $id_ami_form=$_POST['id_ami_form'];

        $requete_refuser="UPDATE  demande_ami set statut_demande='3' where id_utilisateur ='$id_ami' and id_ami='$id_utilisateur'";
        
        if(mysqli_query($bdd,$requete_refuser) ){

            ?>
            <script > 
            swal({
                title: "Validation d'ami.",
                text: "Refus effectué avec succès. " ,
                icon: "success",
                button: "OK",
                }).then(function(){
                    window.location="friend_request.php";
                    });
            </script>
            <?php

        }else{
            ?>
            <script > 
            swal({
                title: "Validation d'ami.",
                text: "Erreur lors de la validation du refus de la demande d'ami, veuillez rééssayer. " ,
                icon: "error",
                button: "OK",
                }).then(function(){
                    window.location="friend_request.php";
                    });
            </script>
            <?php
        }

    }
    //fin demande accepter


    
    ?>
    

    

</div>


<?php include 'inc/footer.php'; ?>