<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php 

    if(!isset($_SESSION['adminname']))
    echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");
    

    if (isset($_POST["submit"])){
      if (empty($_POST["name"])) echo "<script>alert('name cannot be blank')</script>";

      $insert = $conn->prepare("INSERT INTO genres (name) VALUE (:name)");
      $insert->execute([
        ":name" => $_POST["name"],
      ]);
    }
?>


       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Genres</h5>
          <form method="POST" action="create-genres.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="name" id="form2Example1" class="form-control" placeholder="name" />
                 
                </div>
              
              

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>
<?php require "../layouts/footer.php"?>