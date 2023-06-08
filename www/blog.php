<?php
session_start();

include_once "includes/functions.php";
include_once "includes/Post.php";

$_SESSION["REFERER"] = "blog.php";


$referer = isset($_SESSION["REFERER"]) ? $_SESSION["REFERER"] : 'index.php';
$posts = Post::getPosts();
$headTitle = "My Blog";
$metaContent = "Blog for my portfolio website";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "includes/head.php"; ?>
</head>

<body>
  <?php include "includes/header.php";  ?>

  <section class="search_results">
  <div id="blog" class="contact sec-pad dynamicBg">
    <h2 class="heading heading-sec heading-sec__blog">
      <span class="heading-sec__main heading-sec__main--lt">Blog</span>
      <span class="heading-sec__sub heading-sec__sub--lt">
        Visit my blog to follow my journey as a full stack developer, where I share my learnings and experiences from
        my ongoing studies and projects
      </span>
    </h2>
  </div>
  </section>

  <?php if (isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == 'admin') { ?>
    <div class="btn__margin">
      <a href="./create_post.php" class="btn btn--med btn--theme-inv">Create Post</a>
    </div>
  <?php } ?>

  <div class="post__content">
    <div class="projects__row">

      <?php foreach ($posts as $p) { ?>
        <div class="projects__row-img-cont">
          <img src="<?php echo $p->getAvatar() ?>" class="projects__row-img" loading="lazy" />
        </div>
        <div class="projects__row-content">
          <h3 class="projects__row-content-title"><?php echo $p->getTitle() ?></h3>
          <p class="projects__row-content-desc"><?php echo substr("{$p->getContent()}", 0, 170) . '...' ?></p>
          <div class="buttons-container">
            <a href="./post.php?post_id=<?php echo $p->getPostId() ?>" class="btn btn--med btn--theme dynamicBgClr">Read more</a>
            <?php if (isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == 'admin') { ?>
              <a href="./create_post.php?post_id=<?php echo $p->getPostId() ?>" class="btn btn--med btn--theme-inv">Edit</a>
              <a href="./delete_post_proc.php?post_id=<?php echo $p->getPostId() ?>" onclick="showDeleteConfirmation(event)" class="btn btn--med btn--theme-inv">Delete</a>
            <?php } ?>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <?php include "includes/footer.php"; ?>
</body>

</html>
<?php
include 'includes/scripts.php';
?>