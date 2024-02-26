<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php 

  if(!isset($_SESSION['adminname'])){
    // header("location: ".APPURL."");
    echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");

  }


  // if ($_SERVER["REQUEST_METHOD"] == "POST"){
  //   if(isset($_POST['submit']) AND $emailErr == "" AND $adminnameErr == "" AND $passwordErr == ""){

  //     $email = $_POST['email'];
  //     $adminname = $_POST['adminname'];
  //     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  //     $insert = $conn->prepare("INSERT INTO admins (email, adminname, password) VALUE (:email, :adminname, :password)");

  //     $insert->execute([
  //         ":email" => $email,
  //         ":adminname" => $adminname,
  //         ":password" => $password,
  //     ]);
      
  //     // header("location: login.php");
  //     echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");

  //   }
  // }


    if (isset($_POST["submit"])) {
      if(empty($_POST['title']) OR empty($_POST['description']) OR empty($_POST['type']) OR empty($_POST['studios']) OR empty($_POST['date_aired'])
          OR empty($_POST['status']) OR empty($_POST['genre']) OR empty($_POST['duration']) OR empty($_POST['quality']) OR empty($_POST['num_available'])
          OR empty($_POST['num_total']) ) {
            echo ("<script>alert('All feilds must be filled')</script>");
          } else {

            $title = $_POST['title'];
            $description = $_POST['description']; 
            $type = $_POST['type'];
            $studios = $_POST['studios'];
            $date_aired = $_POST['date_aired'];
            $status = $_POST['status'];
            $genre = $_POST['genre'];
            $duration = $_POST['duration'];
            $quality = $_POST['quality'];
            $num_available = $_POST['num_available'];
            $num_total = $_POST['num_total'];
            $image = $_FILES['image']['name'];

            $dir = "img/" . basename($image);

      
            $insert = $conn->prepare("INSERT INTO shows (title, description, type, studios, date_aired, status, genre, duration,
            quality, num_available, num_total, image) 
            VALUE (:title, :description, :type, :studios, :date_aired, :status, :genre, :duration, :quality, :num_available, :num_total, :image)");
      
            $insert->execute([
                ":title" => $title,
                ":description" => $description,
                ":type" => $type,
                ":studios" => $studios,
                ":date_aired" => $date_aired,
                ":status" => $status,
                ":genre" => $genre,
                ":duration" => $duration,
                ":quality" => $quality,
                ":num_available" => $num_available,
                ":num_total" => $num_total,
                ":image" => $image,
                
            ]);
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $dir)){
               header("location: show-shows.php");
              //  echo ("<script>alert('show added successfully')</script>");
              //  echo ("<script>location.href='".ADMINURL."/shows-admins/show-shows.php'</script>");
            }

          }
    }

?>

       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Shows</h5>
          <form method="POST" action="create-shows.php" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="title" id="form2Example1" class="form-control" placeholder="title" />
                 
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="file" name="image" id="form2Example1" class="form-control"  />
                   
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Description</label>
                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="form-outline mb-4 mt-4">

                    <select name="type" class="form-select  form-control" aria-label="Default select example">
                      <option selected>Choose Type</option>
                      <option value="Tv Series">Tv Series</option>
                      <option value="Movie">Movie</option>
                    </select>
                </div>
                <div class="form-outline mb-4 mt-4">
                  <input type="text" name="studios" id="form2Example1" class="form-control" placeholder="studios" />
                 
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="date_aired" id="form2Example1" class="form-control" placeholder="date_aired" />
                   
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="status" id="form2Example1" class="form-control" placeholder="status" />
                   
                </div>
                <div class="form-outline mb-4 mt-4">

                    <select name="genre" class="form-select  form-control" aria-label="Default select example">
                      <option selected>Choose Genre</option>
                      <option value="Tv Series">Magic</option>
                      <option value="Movie">Action</option> 
                      <option value="Movie">Adventure</option>
                    </select>
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="duration" id="form2Example1" class="form-control" placeholder="duration" />
                   
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="quality" id="form2Example1" class="form-control" placeholder="quality" />
                   
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="num_available" id="form2Example1" class="form-control" placeholder="num_available" />
                   
                </div>
                <div class="form-outline mb-4 mt-4">
                    <input type="text" name="num_total" id="form2Example1" class="form-control" placeholder="num_total" />
                   
                </div>
              

                <br>
              

      
                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>

 <?php require "../layouts/footer.php"?>