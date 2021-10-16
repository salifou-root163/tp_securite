<?php 

include 'inc/header.php';

$result = "";
$commentaires = "";

if (!empty($_SESSION["flag"])) {
    $post_id = $_SESSION["postId"];
    $commentaires = mysqli_query($bdd, "SELECT comments.comment_id,post_id,comments.comment_content,comments.date,utilisateur.nom_utilisateur FROM comments INNER JOIN utilisateur ON comments.user_comment_id=utilisateur.id_utilisateur AND comments.post_id=$post_id ORDER BY comments.date DESC");
    
} else {
    $post_id = trim($_POST["postId"]);
    $commentaires = mysqli_query($bdd, "SELECT comments.comment_id,post_id,comments.comment_content,comments.date,utilisateur.nom_utilisateur FROM comments INNER JOIN utilisateur ON comments.user_comment_id=utilisateur.id_utilisateur AND comments.post_id=$post_id ORDER BY comments.date DESC");
}


$post_id = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $post_id = trim($_POST["postId"]);
    $_SESSION["postId"] = $post_id;
    $result = mysqli_query($bdd, "SELECT posts.post_id,posts.post_title,posts.post_content,posts.date,utilisateur.nom_utilisateur FROM posts INNER JOIN utilisateur ON posts.user_id=utilisateur.id_utilisateur AND posts.post_id=$post_id  ORDER BY posts.date DESC");
} else {
    if (!empty($_SESSION["flag"])) {
        $post_id = $_SESSION["postId"];
        $result = mysqli_query($bdd, "SELECT posts.post_id,posts.post_title,posts.post_content,posts.date,utilisateur.nom_utilisateur FROM posts INNER JOIN utilisateur ON posts.user_id=utilisateur.id_utilisateur AND posts.post_id=$post_id  ORDER BY posts.date DESC");
        $_SESSION["flag"] = "";
    } else {
        header("location: posts.php");
    }
}







?>
<div class="container" style="margin-top: 20px;">


    <?php if (mysqli_num_rows($result) > 0) { ?>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <div class="card w-75 mx-auto text-white bg-primary">

                <div class="card-body">
                    <h5 class="card-title">Titre: <?php echo $row["post_title"]; ?></h5>
                    <hr>
                    <br>
                    <p class="card-text"><?php echo $row["post_content"]; ?></p>
                    <div class="d-flex justify-content-between">
                        <div class="p-2 bd-highlight">
                            <strong>
                                <p class="fst-italic">écrit par <?php echo ucfirst($row["nom_utilisateur"]); ?></p>
                            </strong>
                        </div>
                        <div class="p-2 bd-highlight">
                            <p class="fst-italic"><?php echo date("m/d/Y H:i:s", strtotime($row["date"])); ?></p>
                        </div>

                    </div>
                </div>
            </div>



            <hr class="w-75 mx-auto">
    <?php $i++;
        }
    } ?>



    <div class="container w-75 mx-auto">
        <form action="send_comments.php" method="POST">
            <br>
            <?php
            #$_SESSION["postId"] = $row["post_id"];
            echo ' <input type="hidden" name="postId" value="' . $_SESSION['postId'] . '"></input>';
            ?>

            <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="commentaire" placeholder="Saisissez votre commentaire" required></textarea>
            <br>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Commenter</button>
            </div>
        </form>
        <br>
    </div>
    <div class="w-75 mx-auto">
        <h1>Les commentaires</h1>
    </div>

    <hr class="w-75 mx-auto">
    <?php if (mysqli_num_rows($commentaires) > 0) { ?>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($commentaires)) {
        ?>
            <br>
            <br>
            <div class="card border-dark w-75 mx-auto">

                <div class="card-body text-dark">

                    <div class="d-flex justify-content-between">
                        <div class="p-2 bd-highlight">
                            <h6 class="card-title fst-italic text-primary"><?php echo ucfirst($row["nom_utilisateur"]); ?></h6>
                        </div>
                        <div class="p-2 bd-highlight">
                            <h6 class="text-primary fst-italic"><?php echo date("m/d/Y H:i:s", strtotime($row["date"])); ?></h6>
                        </div>

                    </div>
                    <p class="card-text">
                    <p><?php echo $row["comment_content"]; ?></p>
                    </p>
                </div>
            </div>







    <?php $i++;
        }
    } ?>


</div>








<?php include 'inc/footer.php'; ?>