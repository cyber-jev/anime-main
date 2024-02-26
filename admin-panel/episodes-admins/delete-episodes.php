<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php


    if(!isset($_SESSION['adminname']))
    echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");

    // ? Delete an episode

    if (isset($_GET["id"])){

      $id = $_GET['id'];

      $files = $conn->query("SELECT * FROM episodes WHERE id = '$id' ");
      $files->execute();

      $getfiles = $files->fetch(PDO::FETCH_OBJ);

      unlink("videos/" . $getfiles->thumbnail);
      unlink("videos/" . $getfiles->video);
  } 

  $deleteEpisode = $conn->prepare("DELETE FROM episodes WHERE id = :show_id");
  $deleteEpisode->execute([
       ':show_id' => $id,
  ]);

    header("location: show-episodes.php");


?>

<?php require "../layouts/footer.php"?>

