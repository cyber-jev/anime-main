<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 
 
    // echo  "$_SESSION['user_id']" ;

    if(isset($_GET['id']) && !empty($_GET['id'])){


        $id = $_GET['id'];


        $show = $conn->query("SELECT shows.id AS id, shows.image AS image, shows.num_available AS num_available, shows.num_total AS num_total,
        shows.title AS title, shows.genre AS genre, shows.type AS type,  shows.description AS description, shows.duration AS duration, shows.studios AS studios,
        shows.quality AS quality, shows.date_aired AS date_aired, shows.status AS status,
        COUNT(views.show_id) AS count_views FROM `shows` JOIN views ON shows.id = views.show_id WHERE shows.id = '$id' GROUP BY(shows.id)");

        $show->execute();

        $singleShow = $show->fetch(PDO::FETCH_OBJ);

        // for you shows
        $forYouShows = $conn->query("SELECT shows.id AS id, shows.image AS image, shows.num_available AS num_available, shows.num_total AS num_total,
            shows.title AS title, shows.genre AS genre, shows.type AS type, 
        COUNT(views.show_id) AS count_views FROM `shows` JOIN views ON shows.id = views.show_id WHERE shows.status = 'Airing'  GROUP BY(shows.id) ORDER BY views.show_id DESC LIMIT 4");

        $forYouShows->execute();

        $allForYouShows = $forYouShows->fetchAll(PDO::FETCH_OBJ);

        $followErr = "";
        $commentErr = "";
        if (isset($_POST["signin_to_follow"]) && !isset($_SESSION['user_id'])) {
            $followErr = "Please signin to follow show";
        }

        if (isset($_POST["signin_to_comment"]) && !isset($_SESSION['user_id'])) {
            $followErr = "Please signin to comment";
        }

        // *LOGIC FOR FOLLOW AND COMMENT
        
        if(isset($_SESSION['user_id'])){

            if (isset($_POST['follow'])) {

                $show_id = $_POST['show_id'];
                $user_id = $_POST['user_id'];
    
                $follow = $conn->prepare("INSERT INTO followings (show_id, user_id) 
                VALUES (:show_id, :user_id)");
    
                $follow->execute([
                    ":show_id" => $show_id,
                    ":user_id" => $user_id,
                ]);

            } 
            elseif (isset($_POST['unfollow'])) {


                $deleteFollowing = $conn->prepare("DELETE FROM followings WHERE show_id = :show_id AND user_id = :user_id");
                $deleteFollowing->execute([
                    ':show_id' => $id,
                    ':user_id' => $_SESSION['user_id']
                ]);
            }


            // checking ig user followed a show
            $checkFollowing = $conn->query("SELECT * FROM followings WHERE show_id='$id' AND user_id='$_SESSION[user_id]'");
            $checkFollowing->execute();


             // Inserting comments
            if(isset($_POST['comment_btn'])) {
                if (empty($_POST['comment'])){
                    echo "<script>alert('comment is empty')</script>";
                } else {
                    $comment = $_POST['comment'];
                    $show_id = $id;
                    $user_id = $_SESSION['user_id'];
                    $user_name = $_SESSION['username'];

                    $insert = $conn->prepare("INSERT INTO comments (comment, show_id, user_id, user_name ) VALUE (:comment, :show_id, :user_id, :user_name  )");

                    $insert->execute([
                        ":comment" => $comment,
                        ":show_id" => $show_id,
                        ":user_id" => $user_id,
                        ":user_name" => $user_name
                    ]);

                    echo "<script>alert('comment added')</script>";
                }
            }

            //    checking if a user viewed a show
            $checkView = $conn->query("SELECT * FROM views WHERE show_id='$id' AND user_id='$_SESSION[user_id]'");
            $checkView->execute();
        
        
            // echo ("<script>alert('suder id is set')</script>");
            if ($checkView->rowCount() == 0){
                $insertView = $conn->prepare("INSERT INTO views (show_id, user_id)
                VALUES (:show_id, :user_id)");
    
                $insertView->execute([
                    ":show_id" => $id,
                    ":user_id" => $_SESSION['user_id']
                ]);
            }
        } 

        //    Showing Comments
        $comments = $conn->query("SELECT * FROM comments WHERE show_id='$id'");
        $comments->execute();

        $allComments = $comments->fetchAll(PDO::FETCH_OBJ);

    } else {
        
        echo ("<script>location.href='".APPURL."/404.php'</script>");

    }

    

?>

    <!-- Breadcrumb Begin -->
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="<?php echo APPURL ?>"><i class="fa fa-home"></i> Home</a>
                        <a href="<?php echo APPURL ?>/anime-details.php?id=<?php echo $singleShow->id ?>">Details</a>
                        <span><?php echo $singleShow->title ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="anime__details__content">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="anime__details__pic set-bg" data-setbg="img/<?php echo $singleShow->image ?>">
                            <div class="view"><i class="fa fa-eye"></i> <?php echo $singleShow->count_views ?></div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="anime__details__text">
                            <div class="anime__details__title">
                                <h3><?php echo $singleShow->title ?></h3>
                            </div>
                           
                            <p><?php echo $singleShow->description ?></p>
                            <div class="anime__details__widget">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Type:</span><?php echo $singleShow->type ?></li>
                                            <li><span>Studios:</span><?php echo $singleShow->studios ?></li>
                                            <li><span>Date aired:</span><?php echo $singleShow->date_aired ?></li>
                                            <li><span>Status:</span><?php echo $singleShow->status ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <ul>
                                            <li><span>Genre:</span><?php echo $singleShow->genre ?></li>

                                            <li><span>Duration:</span><?php echo $singleShow->duration ?></li>
                                            <li><span>Quality:</span><?php echo $singleShow->quality ?></li>
                                            <li><span>Views:</span><?php echo $singleShow->count_views ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="anime__details__btn">
                                <h4 style="color: wheat; font-weight: bold; margin-bottom: 20px;"><?php echo $followErr?></h4>
                                <form method="POST" action="anime-details.php?id=<?php echo $id ?>" style="display: inline-block;">
                                    <input type="hidden" value="<?php echo $id ?>" name="show_id">
                                    <?php if (isset($_SESSION['user_id'])) : ?>
                                        <input type="hidden" value="<?php echo $_SESSION['user_id'] ?>" name="user_id">
                                    <?php endif ?>

                                    <?php
                                        
                                        if (isset($_SESSION['user_id'])) {
                                            // Check the conditions for showing the follow/unfollow button
                                            if ($checkFollowing->rowCount() > 0 ) :
                                        ?>
                                                <button name="unfollow" type="submit" class="follow-btn"><i class="fa fa-heart-o"></i> Unfollow</button>
                                            <?php else : ?>
                                                <button name="follow" type="submit" class="follow-btn"><i class="fa fa-heart-o"></i> Follow</button>
                                        <?php
                                            endif;

                                        } else { 
                                    ?>
                                        <button name="signin_to_follow" type="submit" class="follow-btn"><i class="fa fa-heart-o"></i> Follow</button> 
                                    
                                    <?php }

                                    ?>

                                        
                                </form>
                                <a href="<?php echo APPURL ?>/anime-watching.php?id=<?php echo $id?>&ep=1" class="watch-btn"><span>Watch Now</span> <i
                                    class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-8">
                        <div class="anime__details__review">
                            <div class="section-title">
                                <h5>Comments</h5>
                            </div>
                            <?php foreach($allComments as $comments) : ?>
                                <div class="anime__review__item">
                                    <!-- <div class="anime__review__item__pic">
                                        <img src="img/anime/review-1.jpg" alt="">
                                    </div> -->
                                    <div class="anime__review__item__text">
                                        <h6><?php echo $comments->user_name ?> <span><?php echo $comments->create_at ?></span></h6>
                                        <p><?php echo $comments->comment ?></p>
                                    </div>
                                </div>
                            <?php endforeach?>
                        </div>
                        <div class="anime__details__form">
                            <div class="section-title">
                                <h5>Your Comment</h5>
                            </div>
                            <h3 style="color: wheat; font-weight: bold; margin-bottom: 20px;"><?php echo $followErr?></h3>

                            <form method="POST" action="<?php echo APPURL ?>/anime-details.php?id=<?php echo $id ?>">
                                <textarea name="comment" placeholder="Your Comment"></textarea>
                                <?php if (!isset($_SESSION["user_id"])) :?>
                                    <button name="signin_to_comment" type=""><i class="fa fa-location-arrow"></i> Comment</button>
                                <?php else : ?>
                                    <button name="comment_btn" type="submit"><i class="fa fa-location-arrow"></i> Comment</button>
                                <?php endif ?>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4">
                        <div class="anime__details__sidebar">
                            <div class="section-title">
                                <h5>you might like...</h5>
                            </div>
                            <?php foreach($allForYouShows as $forYouShow) : ?>

                                <div class="product__sidebar__view__item set-bg" data-setbg="img/<?php echo $forYouShow->image ?>">
                                    <div class="ep"><?php echo $forYouShow->num_available ?> / <?php echo $forYouShow->num_total ?></div>
                                    <div class="view"><i class="fa fa-eye"></i> <?php echo $forYouShow->count_views ?></div>
                                    <h5><a href="<?php echo APPURL ?>/anime-details.php?id=<?php echo $forYouShow->id ?>"><?php echo $forYouShow->title ?></a></h5>
                                </div>

                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Anime Section End -->

<?php require "includes/footer.php"; ?>