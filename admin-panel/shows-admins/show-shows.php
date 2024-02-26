<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php
  
  if(!isset($_SESSION['adminname']))
   echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");
  

  $shows = $conn->query("SELECT shows.id AS id, shows.image AS image, shows.num_available AS num_available, shows.num_total AS num_total,
  shows.title AS title, shows.genre AS genre, shows.type AS type,  shows.description AS description, shows.date_aired AS date_aired, shows.status AS status, shows.created_at AS created_at FROM `shows` ");

  $shows->execute();

  $allShows = $shows->fetchAll(PDO::FETCH_OBJ);

?>

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Shows</h5>
              <a  href="create-shows.php" class="btn btn-primary mb-4 text-center float-right">Create Shows</a>

              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">title</th>
                    <th scope="col">image</th>
                    <th scope="col">type</th>
                    <th scope="col">date_aired</th>
                    <th scope="col">status</th>
                    <th scope="col">genre</th>
                    <th scope="col">num_available</th>
                    <th scope="col">num_total</th>
                    <th scope="col">created_at</th>
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($allShows as $show) : ?>
                    <tr>
                      <th scope="row"><?php echo $show->id ?></th>
                      <td><?php echo $show->title ?></td>
                      <td><img style="width: 70px; height: 70px;" src="<?php echo APPURL?>/img/<?php echo $show->image ?>" alt=""></td>
                      <td><?php echo $show->type ?></td>
                      <td><?php echo $show->date_aired ?></td>
                      <td><?php echo $show->status ?></td>
                      <td><?php echo $show->genre ?></td>
                      <td><?php echo $show->num_available ?></td>
                      <td><?php echo $show->num_total ?></td>
                      <td><?php echo $show->created_at ?></td>
                      <form method="POST" action="<?php echo ADMINURL ?>/shows-admins/delete-shows.php">
                         <input type="hidden" name="id" value="<?php echo $show->id ?>">
                         <td><button name="delete-btn" type="submit" href="delete-shows.html" class="btn btn-danger  text-center ">delete</button></td>
                      </form>
                    </tr>
                  <?php endforeach?>
                </tbody>
              </table> 
            </div>
          </div>
        </div>

<?php require "../layouts/footer.php"?>