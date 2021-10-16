<?php 

include 'inc/header.php';


$_SESSION["flag"]="";


$post_id = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $commentaire = trim($_POST["commentaire"]);
    $post_id = trim($_POST["postId"]);
    $user_id=$_SESSION["id_utilisateur"];

    $sql = "INSERT INTO comments (user_comment_id, post_id,comment_content) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($bdd, $sql)) {
       
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_user_Comment_id, $param_post_id, $param_comment_content);

        // Set parameters
        $param_user_Comment_id = $user_id;
        $param_post_id = $post_id;
        $param_comment_content = $commentaire;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            
            $_SESSION["flag"]=1;

            header("location: comments.php");
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close connection
    mysqli_close($bdd);
} 






?>






<?php include 'inc/footer.php'; ?>