    <?php require "./includes/header.php" ?>
    <?php require "./config/config.php" ?>

    <?php 
    


        if(isset($_GET['name'])) {

            $name = $_GET['name'];

            $shows = $conn->query("SELECT shows.id AS id, shows.image AS image, shows.num_available AS num_available, shows.num_total AS num_total,
            shows.title AS title, shows.genre AS genre, shows.type AS type, 
           COUNT(views.show_id) AS count_views FROM `shows` JOIN views ON shows.id = views.show_id WHERE shows.genre = '$name' GROUP BY(shows.id) ORDER BY views.show_id ASC");
            $shows->execute();

            $allShows = $shows->fetchAll(PDO::FETCH_OBJ);

            $forYouShows = $conn->query("SELECT shows.id AS id, shows.image AS image, shows.num_available AS num_available, shows.num_total AS num_total,
            shows.title AS title, shows.genre AS genre, shows.type AS type, 
           COUNT(views.show_id) AS count_views FROM `shows` JOIN views ON shows.id = views.show_id WHERE shows.status = 'Airing'  GROUP BY(shows.id) ORDER BY views.show_id DESC LIMIT 4");
        
           $forYouShows->execute();
        
           $allForYouShows = $forYouShows->fetchAll(PDO::FETCH_OBJ);
           
        } else {
        
            echo ("<script>location.href='".APPURL."/404.php'</script>");
    
        }
    
    ?>
    <!-- Header End -->

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="<?php echo APPURL?>"><i class="fa fa-home"></i> Home</a>
                        <a href="<?php echo APPURL?>/categories.php?name=<?php echo $name; ?>">Categories</a>
                        <span><?php echo $name; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Section Begin -->
    <section class="product-page spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product__page__content">
                        <div class="product__page__title">
                            <div class="row">
                                <div class="col-lg-8 col-md-8 col-sm-6">
                                    <div class="section-title">
                                        <h4><?php echo $name; ?></h4>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                        <div class="row">
                            <?php if(count($allShows) < 1) : ?> 
                                <h4 style="color: white;">No shows in this genre yet </h4>
                            <?php endif ?>
                            <?php foreach($allShows as $show) : ?>
                                <div class="col-lg-4 col-md-6 col-sm-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="img/<?php echo $show->image; ?>">
                                            <div class="ep"><?php echo $show->num_available; ?> / <?php echo $show->num_total; ?></div>
                                            <div class="view"><i class="fa fa-eye"></i><?php echo $show->count_views; ?></div>
                                        </div>
                                        <div class="product__item__text">
                                            <ul>
                                                <li><?php echo $show->genre; ?></li>
                                                <li><?php echo $show->type; ?></li>
                                            </ul>
                                            <h5><a href="<?php echo APPURL; ?>/anime-details.php?id=<?php echo $show->id; ?>"><?php echo $show->title; ?></a></h5>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                   
                </div>
                <div class="col-lg-4 col-md-6 col-sm-8">
                    <div class="product__sidebar">
                        <div class="product__sidebar__view">
                        </div>
                    <!-- </div>
                </div>         -->
    </div>
    <div class="product__sidebar__comment">
        <div class="section-title">
            <h5>FOR YOU</h5>
        </div>
        <?php foreach($allForYouShows as $forYouShow) : ?>
            <div class="product__sidebar__comment__item">
                <div class="product__sidebar__comment__item__pic">
                    <img style="width: 130px; height: 150px;" src="img/<?php echo $forYouShow->image ?>" alt="">
                </div>
                <div class="product__sidebar__comment__item__text">
                    <ul>
                        <li><?php echo $forYouShow->genre ?></li>
                        <li><?php echo $forYouShow->type ?></li>
                    </ul>
                    <h5><a href="<?php echo APPURL ?>/anime-details.php?id=<?php echo $forYouShow->id ?>"><?php echo $forYouShow->title?></a></h5>
                    <span><i class="fa fa-eye"></i><?php echo $forYouShow->count_views ?></span>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>
</div>
</div>
</div>
</section>
<!-- Product Section End -->

<!-- Footer Section Begin --> 
<?php require "./includes/footer.php" ?>