<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php
  
  if(!isset($_SESSION['adminname']))
   echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");
  
  // ? Delete a show
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
      if (isset($_POST['delete-btn'])) {

        $id = $_POST['id'];

        $image = $conn->query("SELECT * FROM shows WHERE id = '$id' ");
        $image->execute();
  
        $getImage = $image->fetch(PDO::FETCH_OBJ);
  
        unlink("img/" . $getImage->image);
        } 

        $deleteShow = $conn->prepare("DELETE FROM shows WHERE id = :show_id");
        $deleteShow->execute([
            ':show_id' => $id,
        ]);

        header("location: show-shows.php");
  }

 ?> 