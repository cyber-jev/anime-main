<?php 
//    ?? showing error
     error_reporting(E_ALL); 
    ini_set('display_errors', 1);

// ?? show error end

    session_start();
    define("APPURL", "http://localhost/anime-main");



    require dirname(dirname(__FILE__)) . "/config/config.php"; 

    $categories = $conn->query("SELECT * FROM genres");
    $categories->execute();

    $allCategories = $categories->fetchAll(PDO::FETCH_OBJ);

?><!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anime | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/plyr.css" type="text/css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="<?php echo APPURL; ?>/css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="<?php echo APPURL; ?>">
                            <img src="<?php echo APPURL; ?>/img/logo.png" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li><a href="<?php echo APPURL; ?>">Homepage</a></li>
                                <li><a href="#">Categories <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <?php foreach( $allCategories as $categorie) : ?>
                                         <li><a href="<?php echo APPURL; ?>/categories.php?name=<?php echo $categorie->name?>"><?php echo $categorie->name ?></a></li>
                                        <?php endforeach ?>
                                    </ul>
                                </li>

                                <?php if(isset($_SESSION['username'])) : ?>
                                <li><a href="#"><?php echo $_SESSION['username']; ?> <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="<?php echo APPURL ?>/users/followings.php">Following</a></li>
                                        <li><a href="<?php echo APPURL; ?>/auth/logout.php">Logout</a></li>
                                    </ul>
                                </li>
                                <?php endif; ?>    
                                <?php if(!isset($_SESSION['username'])) : ?>
                                   <a href="<?php echo APPURL; ?>/auth/login.php"><span class="icon_profile"></span></a>
                                <?php endif; ?>

                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="header__right" style="display: flex; align-items:center; gap: .6em;">
                        <!-- <a href="#" class="search-switch"><span class="icon_search"></span></a> -->
                        <form action="<?php echo APPURL?>/search.php" method="POST" class="d-flex">
                            <input name="keyword" style="margin:0 .5em 0 -4em; width: 9em;" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                            <button name="submit" type="submit" style="color:#46392c; background-color: white; outline:none;" class="btn btn-outline-success" type="submit">Search</button>
                        </form>


                    </div>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>