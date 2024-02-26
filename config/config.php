<?php

try {
    //host
    $HOST = "localhost";

    //dbname
    $DBNAME = "anime";

    //user
    $USER = "root";

    //pass
    $PASS = "9090";


    $conn = new PDO("mysql:host=".$HOST.";dbname=".$DBNAME."", $USER, $PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // if($conn == true) {
    //     echo "db connection is a success";
    // } else {
    //     echo "db error";
    // }

} catch (PDOException $e) {
    print "Error: " . $e->getMessage();
    // echo $e->getMessage();

}