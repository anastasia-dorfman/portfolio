<?php
//displays all the details for a particular Bitter user

session_start();

include_once "includes/functions.php";
include_once "includes/Post.php";

// if (!(isset($_SESSION["USERNAME"]))) {
//     //TODO check type of user...
//     // header('Location:login.php');
//     exit;
// }

if (!(isset($_GET['post_id'])) || empty($_GET['post_id'])) {
    setFeedbackAndRedirect("Choose a post to show", "error");
}

$postId = $_GET['post_id'];
// $_SESSION["REFERER"] = "post.php?post_id=".$userToSeeId;

$referer = isset($_SESSION["REFERER"]) ? $_SESSION["REFERER"] : 'index.php';
$post = Post::getPostById($postId);
$images = $post->getImages();
$tags = $post->getTags();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?php echo $post->getTitle() ?></title>
    <meta name="description" content="Case study page of Project" />

    <link rel="stylesheet" href="includes/css/style.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700;900&display=swap" rel="stylesheet" />
</head>

<body>
    <?php
    include "includes/header.php";
    ?>
    <div class="post">
        <div class="post__title">
            <h1 class="heading-post"><?php echo $post->getTitle() ?></h1>
        </div>
    </div>
    <div class="post__content">
        <div class="post__row">
            <div class="post__col">
                <img src="<?php echo $post->getAvatar() ?>" alt="Project Image" class="post__avatar" />
                <div class="post__row">
                    <?php
                    foreach ($images as $i) {
                    ?>
                        <img src="<?php echo $i ?>" alt="Project Image" class="post__img" />
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="post__content-main">
                <p class="project-details__desc-para"><?php echo $post->getContent() ?></p>
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
    <script src="./index.js"></script>
</body>

</html>

<?php
include 'includes/scripts.php';
?>