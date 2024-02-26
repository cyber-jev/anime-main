<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php 

    if(!isset($_SESSION['adminname']))
    echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");


    if (isset($_GET["id"])){

        $id = $_GET["id"];

        $deleteGenre = $conn->prepare("DELETE FROM genres WHERE id = '$id'");
        $deleteGenre->execute();
    }

    header("location: show-genres.php");

?>