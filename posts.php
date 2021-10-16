<?php 

include 'inc/header.php';

$result = mysqli_query($bdd, "SELECT posts.post_id,posts.post_title,posts.post_content,posts.date,utilisateur.nom_utilisateur FROM posts INNER JOIN utilisateur ON posts.user_id=utilisateur.id_utilisateur ORDER BY posts.date DESC");




if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $post_title = trim($_POST["titre"]);
    $post_content = trim($_POST["message"]);
    $user_id = $_SESSION["id_utilisateur"];

    $sql = "INSERT INTO posts (user_id, post_title,post_content) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($bdd, $sql)) {
        
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_user_id, $param_post_title, $param_post_content);

        // Set parameters
        $param_user_id = $user_id;
        $param_post_title = $post_title;
        $param_post_content = $post_content;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to posts page
            
            header("location: posts.php");
        } else {
            echo "Hasn't Excuted";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($bdd);
}







?>




<div class="container homeContainer w-80 mx-auto">
    <h1 class="text-primary w-75 mx-auto">Publier dans le forum</h1>
    <hr class="text-primary w-75 mx-auto">
    <br>

    <br>
    <div class="w-75 mx-auto">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <input class="form-control" type="text" name="titre" id="" placeholder="Saisissez le sujet du post" required>
            <br>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="message" placeholder="Saisissez le contenu de votre post" required></textarea>
            <br>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Publier</button>
            </div>
        </form>
    </div>


    <hr>
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <?php $i = 0;
        while ($row = mysqli_fetch_array($result)) {
        ?>
            <div class="card w-75 mx-auto text-dark bg-light">
                <div class="card-body">
                    <h4 class="card-title">Titre: <?php echo ucfirst($row["post_title"]); ?></h4>
                    <hr>
                    <p class="card-text" style="text-justify:inter-word; text-align:justify"><?php echo $row["post_content"]; ?></p>

                    <div class="d-flex justify-content-between">
                        <div class="p-2 bd-highlight">
                            <p class="fst-italic text-primary">
                                écrit par <?php echo ucfirst($row["nom_utilisateur"]); ?></p>
                        </div>
                        <div class="p-2 bd-highlight">

                            <p class="fst-italic text-primary"><?php echo date("m/d/Y H:i:s", strtotime($row["date"])); ?></p>
                        </div>

                    </div>

                    <div class="d-flex flex-row-reverse bd-highlight">
                        <form action="comments.php" method="post">

                            <div class="p-2 bd-highlight">
                                <?php
                                $_SESSION["postId"] = $row["post_id"];
                                echo ' <input type="hidden" name="postId" value="' . $_SESSION['postId'] . '"></input>';
                                ?>

                            </div>
                            <div class="p-2 bd-highlight"><button type="submit" class="btn btn-outline-dark">Commenter</button> </div>

                        </form>


                    </div>


                </div>
            </div>


            <br>





    <?php $i++;
        }
    } ?>

</div>


<?php include 'inc/footer.php'; ?>