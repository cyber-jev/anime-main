<?php 

    session_start();
    session_unset();
    session_destroy();

    // header("location: ".APPURL."");
    header("location: http://localhost/anime-main/admin-panel/admins/login-admins.php");
    // echo ("<script>location.href='".ADMINURL."'</script>");