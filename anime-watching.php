<?php require "includes/header.php"; ?>
<?php require "config/config.php"; ?>
<?php 

    if(isset($_GET['id']) AND isset($_GET['ep'])) {
        
        $id = $_GET['id'];
        $ep = $_GET['ep'];

        $episodes = $conn->query("SELECT * FROM episodes WHERE show_id='$id'");
        $episodes->execute();

        $allEpisodes = $episodes->fetchAll(PDO::FETCH_OBJ);

        // grabbing episode videos
        $episode = $conn->query("SELECT * FROM episodes WHERE show_id='$id' AND name='$ep'");
        $episode->execute();

        $singleEpisode = $episode->fetch(PDO::FETCH_OBJ);

        // show data for breadcrumb
        $show = $conn->query("SELECT * FROM shows WHERE id='$id'");
        $show->execute();

        $singleshow = $show->fetch(PDO::FETCH_OBJ);

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
    
               // Showing Comments
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
                        <a href="<?php echo APPURL ?>/categories.php?name=<?php echo $singleshow->genre ?>">Categories</a>
                        <a href="#"><?php echo $singleshow->genre ?></a>
                        <span><?php echo $singleshow->title ?> /</span>
                        <?php if (!isset($singleEpisode->name) || empty($singleEpisode->name)) : ?>
                            <span style="color: red;">There is no episode yet</span>
                        <?php else : ?>    
                            <?php try { ?>
                                <span style="color: red;">Episode <?php echo $singleEpisode->name ?></span>
                            <?php } catch (Exception $e) { ?>
                                <span style="color: red;">Error: <?php echo $e->getMessage(); ?></span>
                            <?php } ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Anime Section Begin -->
    <section class="anime-details spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="anime__video__player">
                        <video id="player" playsinline controls data-poster="<?php echo APPURL ?>/admin-panel/episodes-admins/videos/<?php echo $singleEpisode->thumbnail ?>">
                            <source src="<?php echo APPURL ?>/admin-panel/episodes-admins/videos/<?php echo $singleEpisode->video ?>" type="video/mp4" />
                            <!-- Captions are optional -->
                            <!-- <track kind="captions" label="English captions" src="#" srclang="en" default /> -->
                        </video>
                    </div>
                    <div class="anime__details__episodes">
                        <div class="section-title">
                            <h5>List Name</h5>
                        </div>
                        <?php foreach($allEpisodes as $episode) : ?>
                            <a href="<?php echo APPURL; ?>/anime-watching.php?id=<?php echo $episode->show_id ?>&ep=<?php echo $episode->name ?>">Ep <?php echo $episode->name ?></a>
                        <?php endforeach ?>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
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
                        <form method="POST" action="<?php echo APPURL ?>/anime-watching.php?id=<?php echo $id ?>&ep=<?php echo $ep ?>">
                            <textarea name="comment" placeholder="Your Comment"></textarea>
                            <button name="comment_btn" type="submit"><i class="fa fa-location-arrow"></i> Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Anime Section End -->

    <?php require "includes/footer.php"; ?>