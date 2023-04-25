<?php
//displays all posts
session_start();

include_once "includes/functions.php";
include_once "includes/Post.php";

// if (!(isset($_SESSION["USERNAME"]))) {
//     //TODO check type of user...
//     // header('Location:login.php');
//     exit;
// }

$referer = isset($_SESSION["REFERER"]) ? $_SESSION["REFERER"] : 'index.php';
$posts = Post::getPosts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Anastasia Dorfman - Blog</title>
  <meta name="description" content="Portfolio Template for Developer" />

  <link rel="stylesheet" href="includes/css/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700;900&display=swap" rel="stylesheet" />
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon_io/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon_io/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon_io/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
</head>

<body>
  <?php
  include "includes/header.php";
  ?>
  <div id="blog" class="projects sec-pad">
    <div class="main-container">
      <h2 class="heading heading-sec heading-sec__mb-bg">
        <span class="heading-sec__main">Blog</span>
        <span class="heading-sec__sub">
          Visit my blog to follow my journey as a full stack developer, where I share my learnings and experiences from
          my ongoing studies and projects
        </span>
      </h2>

      <div class="projects__content">
        <div class="projects__row">

          <?php
          foreach ($posts as $p) {
          ?>
            <div class="projects__row-img-cont">
              <img src="<?php echo $p->getAvatar() ?>" alt="Software Screenshot" class="projects__row-img" loading="lazy" />
            </div>
            <div class="projects__row-content">
              <h3 class="projects__row-content-title"><?php echo $p->getTitle() ?></h3>
              <p class="projects__row-content-desc"><?php echo substr("{$p->getContent()}", 0, 170).'...' ?></p>
              <a href="./post.php?post_id=<?php echo $p->getPostId() ?>" class="btn btn--med btn--theme dynamicBgClr" target="_blank">Read more</a>
            </div>
            <?php //echo $t ?>
          <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <?php
  include "includes/footer.php";
  ?>
  <script src="./index.js"></script>
</body>

</html>