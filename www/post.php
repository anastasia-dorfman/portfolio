<?php

session_start();

include_once "includes/functions.php";
include_once "includes/Post.php";

if (!(isset($_GET['post_id'])) || empty($_GET['post_id'])) {
    setFeedbackAndRedirect("Choose a post to show", "error");
}

$postId = $_GET['post_id'];

$_SESSION["REFERER"] = "post.php?post_id=" . $postId;

$post = Post::getPostById($postId);
$images = $post->getImages();
$tags = $post->getTags();

$headTitle = $post->getTitle();
$metaContent = "$headTitle, Anastasia Dorfman's portfolio website, full stack developer";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head.php"; ?>
</head>

<body>
    <?php
    include "includes/header.php";
    ?>
    <div class="contact sec-pad">
        <div class="post">
            <div class="post__title">
                <h1 class="heading-post"><?php echo $post->getTitle() ?></h1>
            </div>
        </div>
    </div>

    <?php
    if (isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == 'admin') {
    ?>
        <div class="btn__margin">
            <a href="./create_post.php?post_id=<?php echo $postId ?>" class="btn btn--med btn--theme-inv">Edit Post</a>
            <a href="./delete_post_proc.php?post_id=<?php echo $postId ?>" onclick="showDeleteConfirmation(event)" class="btn btn--med btn--theme-inv">Delete Post</a>
        </div>
    <?php
    }
    ?>

    <div class="post__content">
        <div class="post__row">
            <div class="post__col">
                <img src="<?php echo $post->getAvatar() ?>" class="post__avatar" />
                <div class="post__row">
                    <?php
                    foreach ($images as $i) {
                    ?>
                        <img src="<?php echo $i ?>" class="post__img" />
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="post__content-main">
                <p class="project-details__desc-para"><?php echo $post->getContent() ?></p>
                <br>
                <div class="project-details__tools-used">
                    <h3 class="project-details__content-title">Tags</h3>
                    <div class="skills">
                        <?php
                        foreach ($tags as $t) {
                        ?>
                            <div class="skills__skill">
                                <?php echo $t ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <a href="./blog.php" class="btn btn--med btn--theme-inv btn-back" target="_blank">Back to Blog</a>
    </div>

    <?php
    include "includes/footer.php";
    ?>
</body>

</html>

<?php
include 'includes/scripts.php';
?>