<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php 

  if(!isset($_SESSION['adminname'])){
    // header("location: ".APPURL."/admins/login-admins.php");
    echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");

  }

  // show admins
  $admins = $conn->query("SELECT admins.id AS id, admins.email AS email, admins.adminname AS adminname FROM `admins`");
  $admins->execute();
  $allAdmins = $admins->fetchAll(PDO::FETCH_OBJ);
?>

      <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Admins</h5>
             <a  href="<?php echo ADMINURL?>/admins/create-admins.php" class="btn btn-primary mb-4 text-center float-right">Create Admins</a>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">adminname</th>
                      <th scope="col">email</th>
                    </tr>
                  </thead>
                  <?php foreach($allAdmins as $admin) : ?>

                    <tbody>
                      <tr>
                        <th scope="row"><?php echo $admin->id ?></th>
                        <td><?php echo $admin->adminname ?></td>
                        <td><?php echo $admin->email ?></td>
                      
                      </tr>
                    </tbody>
                  <?php endforeach ?>
                </table> 
                
            </div>
          </div>
        </div>
<?php require "../layouts/footer.php"?>