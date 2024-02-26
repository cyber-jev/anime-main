<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php 

    if(!isset($_SESSION['adminname']))
    echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");

    $episodes = $conn->query("SELECT episodes.id AS id, episodes.video AS video, episodes.thumbnail AS thumbnail,
    episodes.show_id AS show_id, episodes.name AS name FROM `episodes`");
    $episodes->execute();

    $allEpesodes = $episodes->fetchAll(PDO::FETCH_OBJ);

  
?>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Episodes</h5>
              <a  href="create-episodes.php" class="btn btn-primary mb-4 text-center float-right">Create Episodes</a>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <!-- <th scope="col">video</th> -->
                    <th scope="col">Thumbnail</th>
                    <th scope="col">Name</th>
                    <th scope="col">Show Id</th>
                    
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allEpesodes as $episode) :?>
                    <tr>
                      <th scope="row"><?php echo $episode->id?></th>
                      <!-- <td><?php echo $episode->video?></td> -->
                      <td><img src="videos/<?php echo $episode->thumbnail?>" alt="" style="width: 70px; height: 70px;"></td>
                      <td>ep <?php echo $episode->name?></td>
                      <td><?php echo $episode->show_id?></td>

                      <td><a href="delete-episodes.php?id=<?php echo $episode->id?>" class="btn btn-danger  text-center ">delete</a></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
<?php require "../layouts/footer.php"?>