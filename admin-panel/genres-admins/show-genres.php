<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php 

    if(!isset($_SESSION['adminname']))
    echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");

      // ? Delete a show
    // if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //   if (isset($_POST['delete-btn'])) {

    //     $id = $_POST['id'];

    //     $image = $conn->query("SELECT * FROM shows WHERE id = '$id' ");
    //     $image->execute();

    //     $getImage = $image->fetch(PDO::FETCH_OBJ);

    //     unlink("img/" . $getImage->image);
    //     } 

    //     $deleteShow = $conn->prepare("DELETE FROM shows WHERE id = :show_id");
    //     $deleteShow->execute([
    //         ':show_id' => $id,
    //     ]);

    // }

    $genres = $conn->query("SELECT genres.id AS id, genres.name AS name FROM `genres` ");

    $genres->execute();

    $allGenres = $genres->fetchAll(PDO::FETCH_OBJ);
    
?>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Genres</h5>
              <a  href="create-genres.php" class="btn btn-primary mb-4 text-center float-right">Create Genres</a>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allGenres as $genre) : ?>
                    <tr>
                      <th scope="row"><?php echo $genre->id?></th>
                      <td><?php echo $genre->name?></td>
                      
                      <td><a href="delete-genres.php?id=<?php echo $genre->id?>" class="btn btn-danger  text-center ">delete</a></td>
                    </tr>
                  <?php endforeach?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
<?php require "../layouts/footer.php"?>