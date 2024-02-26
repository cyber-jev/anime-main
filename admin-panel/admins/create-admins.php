<?php require "../layouts/header.php"?>
<?php require "../../config/config.php"?>
<?php

  if(!isset($_SESSION['adminname'])){
    // header("location: ".APPURL."");
    echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");

  }


  //* THIs is a proper form validation
  //define variables and set to empty values
  $emailErr = $adminnameErr = $passwordErr = "";
  $email = $adminname = $password = "";

  function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  //validate email
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
      if (empty($_POST["email"])) $emailErr = "Email is Require";
      else {
        $email = test_input($_POST["email"]);
        //check if name only contains letters and whitespace
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
          $emailErr = "Invalid email format";
        }
      }
  }

  //validate adminname
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["adminname"])) $adminnameErr = "Adminname is Require";
    else {
      $adminname = test_input($_POST["adminname"]);
      //check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z-' ]*$/", $adminnameErr)){
        $adminnameErr = "Only letters and white space allowed";
      }
    }
  }

  // validate password
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["password"])) $passwordErr = "password is Require";
    else {
      $password = test_input($_POST["password"]);
      //check if name only contains letters and whitespace
      if (strlen($password) < 4){
        $passwordErr = "password must be at least 4 characters";
      }
    }
  }


  // creating a new admin
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
   
    if(isset($_POST['submit']) AND $emailErr == "" AND $adminnameErr == "" AND $passwordErr == ""){

      $email = $_POST['email'];
      $adminname = $_POST['adminname'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      $insert = $conn->prepare("INSERT INTO admins (email, adminname, password) VALUE (:email, :adminname, :password)");

      $insert->execute([
          ":email" => $email,
          ":adminname" => $adminname,
          ":password" => $password,
      ]);
      
      // header("location: login.php");
      echo ("<script>location.href='".ADMINURL."/admins/login-admins.php'</script>");

    }
    
  }

?>

       <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-5 d-inline">Create Admins</h5>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data">
                <!-- Email input -->
                <div class="form-outline mb-4 mt-4">
                  <input type="email" name="email" id="form2Example1" class="form-control" placeholder="email" value="<?php echo $email?>"/>
                  <span style="color: red;"><?php echo $emailErr?></span>
                 
                </div>

                <div class="form-outline mb-4">
                  <input type="text" name="adminname" id="form2Example1" class="form-control" placeholder="adminname" value="<?php echo $adminname?>" />
                  <span style="color: red;"><?php echo $adminnameErr?></span>
                </div>
                <div class="form-outline mb-4">
                  <input type="password" name="password" id="form2Example1" class="form-control" placeholder="password" value="<?php echo $password?>"/>
                  <span style="color: red;"><?php echo $passwordErr?></span>
                </div>

               
            
                
              


                <!-- Submit button -->
                <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>

          
              </form>

            </div>
          </div>
        </div>

<?php require "../layouts/footer.php"?>
