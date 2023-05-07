<?php
session_start();

include_once "includes/functions.php";
include_once "includes/Project.php";
include_once "includes/Post.php";

$searchQuery = isset($_POST["search"]) ? $_POST["search"] : '';

$_SESSION["REFERER"] = "search_results.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Anastasia Dorfman</title>
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
  <?php include "includes/header.php"; ?>

  <section class="header__search_results">
    <div class="contact sec-pad dynamicBg">
      <h1 class="heading-primary">Search Results</h1>
      <div class="home-hero__info">
        <p class="text-primary">Showing results for "<?php echo $searchQuery; ?>"</p>
      </div>
    </div>
  </section>
  <?php
  // if ((isset($_POST["search"]))) {
  if ($searchQuery !== '') {
    $projects = Project::searchProjects($searchQuery);
  ?>
    <section class="projects sec-pad">
      <div class="main-container">
        <?php
        if (empty($projects)) { ?>
          <h3 class="projects__row-content-title heading-sec__main">No projects found matching your search query</h3>
        <?php } else { ?>
          <h3 class="heading heading-sec heading-sec__mb-bg"><span class="heading-sec__main">Projects Found</span></h3>
          <?php foreach ($projects as $p) {
            $projectId = $p->getProjectId();
          ?>
            <div class="projects__content">
              <div class="projects__row">
                <div class="projects__row-img-cont">
                  <img src="<?php echo $p->getAvatar() ?>" alt="Project Screenshot" class="projects__row-img" loading="lazy" />
                </div>
                <div class="projects__row-content">
                  <h3 class="projects__row-content-title"><?php echo $p->getName() ?></h3>
                  <p class="projects__row-content-desc"><?php echo $p->getDescription() ?></p>
                  <div class="buttons-container">
                    <a href="./project.php?project_id=<?php echo $projectId ?>" class="btn btn--med btn--theme dynamicBgClr">Case Study</a>
                    <?php if (isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == 'admin') { ?>
                      <a href="./create_project.php?project_id=<?php echo $projectId ?>" class="btn btn--med btn--theme-inv">Edit</a>
                      <a href="./delete_project_proc.php?project_id=<?php echo $projectId ?>" onclick="return confirm('Are you sure you want to delete the project?')" class="btn btn--med btn--theme-inv">Delete</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </section>
    <section class="about sec-pad">
      <div class="main-container">
        <?php
        $posts = Post::searchPosts($searchQuery);
        if (empty($posts)) { ?>
          <h3 class="projects__row-content-title heading-sec__main">No posts found matching your search query</h3>
        <?php } else { ?>
          <h3 class="heading heading-sec heading-sec__mb-bg"><span class="heading-sec__main">Posts Found</span></h3>
          <?php foreach ($posts as $p) {
            $postId = $p->getPostId();
          ?>
            <div class="projects__content">
              <div class="projects__row">
                <div class="projects__row-img-cont">
                  <img src="<?php echo $p->getAvatar() ?>" alt="Project Screenshot" class="projects__row-img" loading="lazy" />
                </div>
                <div class="projects__row-content">
                  <h3 class="projects__row-content-title"><?php echo $p->getTitle() ?></h3>
                  <p class="projects__row-content-desc"><?php echo substr("{$p->getContent()}", 0, 170). '...' ?></p>
                  <div class="buttons-container">
                    <a href="./project.php?project_id=<?php echo $projectId ?>" class="btn btn--med btn--theme dynamicBgClr">Read more</a>
                    <?php if (isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == 'admin') { ?>
                      <a href="./create_project.php?project_id=<?php echo $projectId ?>" class="btn btn--med btn--theme-inv">Edit</a>
                      <a href="./delete_project_proc.php?project_id=<?php echo $projectId ?>" onclick="return confirm('Are you sure you want to delete the project?')" class="btn btn--med btn--theme-inv">Delete</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </section>
    <?php exit(); ?>
  <?php } else { ?>
    <h3 class="projects__row-content-title heading-sec__main">No search criteria chosen</h3>
  <?php } ?>

  <?php include "includes/footer.php";  ?>
  <script src="./index.js"></script>
</body>

</html>

<?php include 'includes/scripts.php'; ?>