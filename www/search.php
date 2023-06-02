<?php
session_start();

include_once "includes/functions.php";
include_once "includes/Project.php";
include_once "includes/Post.php";

$searchQuery = '';

if (isset($_POST["search_query"]) || isset($_POST["search_query_form"]))
  $searchQuery = isset($_POST["search_query"]) ? $_POST["search_query"] : $_POST["search_query_form"];

if (isset($_POST["clear_btn"]) || $_SESSION["REFERER"] != "search.php") {
  unset($_SESSION['framework']);
  unset($_SESSION['language']);
  unset($_SESSION['database']);
  unset($_SESSION['tag']);
}

$_SESSION["REFERER"] = "search.php";
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <?php
  include "includes/header.php";

  $frameworks = Project::getAllTools('framework');
  $languages = Project::getAllTools('language');
  $databases = Project::getAllTools('database');
  $tags = Post::getTagsOtherThanTools();
  ?>

  <div class="search_results sec-pad">
    <div class="search-container">
      <form action="search.php" id="clear" method="POST" role="search"></form>
      <form action="search.php" id="search_form" method="POST" role="search">
        <input type="search" name="search_query_form" placeholder="Search..." class="input--theme input--theme-inv input-large" value="<?php echo $searchQuery ?? '' ?>" />

        <div class="select-container">
          <select id="framework" name="framework" class="select--theme select--theme-inv select-width" onchange="onSelectChange()">
            <option value=''>Select Framework</option>
            <?php
            // if (isset($_POST['framework']) && !empty($_POST['framework'])) {
            if (isset($_POST['framework'])) {
              $_SESSION['framework'] = $_POST['framework'];
            }
            $filterFramework = isset($_SESSION['framework']) ? $_SESSION['framework'] : '';

            foreach ($frameworks as $f) {
              $selected = $filterFramework == $f ? 'selected' : ''; ?>
              <option value="<?php echo $f ?>" <?php echo $selected ?>><?php echo $f ?></option>
            <?php } ?>
          </select>

          <select name="language" class="select--theme select--theme-inv select-width" onchange="onSelectChange()">
            <option value="">Select Language</option>
            <?php
            if (isset($_POST['language'])) {
              $_SESSION['language'] = $_POST['language'];
            }
            $filterLanguage = isset($_SESSION['language']) ? $_SESSION['language'] : '';

            foreach ($languages as $l) {
              $selected = $filterLanguage == $l ? 'selected' : ''; ?>
              <option value="<?php echo $l ?>" <?php echo $selected; ?>><?php echo $l ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="select-container">
          <select name="database" class="select--theme select--theme-inv select-width" onchange="onSelectChange()">
            <option value="">Select Database</option>
            <?php
            // if (isset($_POST['database']) && !empty($_POST['database'])) {
            if (isset($_POST['database'])) {
              $_SESSION['database'] = $_POST['database'];
            }
            $filterDatabase = isset($_SESSION['database']) ? $_SESSION['database'] : '';

            foreach ($databases as $d) {
              $selected = $filterDatabase == $d ? 'selected' : ''; ?>
              <option value="<?php echo $d ?>" <?php echo $selected ?>><?php echo $d ?></option>
            <?php } ?>
          </select>

          <select name="tag" class="select--theme select--theme-inv select-width" onchange="onSelectChange()">
            <option value="">Select Tag (for posts)</option>
            <?php
            if (isset($_POST['tag'])) {
              $_SESSION['tag'] = $_POST['tag'];
            }
            $filterTag = isset($_SESSION['tag']) ? $_SESSION['tag'] : '';

            foreach ($tags as $t) {
              $selected = $filterTag == $t ? 'selected' : ''; ?>
              <option value="<?php echo $t ?>" <?php echo $selected ?>><?php echo $t ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="button-container">
          <button type="submit" name="search_form_btn" class="btn btn--sm btn--theme-inv ml-1" onclick="onSelectChange()">Search</button>
          <button type="submit" name="clear_btn" class="btn btn--sm btn--theme-inv clear-btn" form="clear">Clear</button>
        </div>
      </form>
    </div>
    <h1 class="heading-primary">Search Results</h1>
      <p class="text-primary">Showing results for "<?php echo $searchQuery; ?>"</p>
  </div>
  <?php

  // Getting list of Projects and Posts
  if ($searchQuery !== null) {
    $projects = Project::searchProjects($searchQuery);
    $posts = Post::searchPosts($searchQuery);

    $filters = [];

    if (!empty($_POST['framework'])) {
      array_push($filters, $_POST['framework']);
    }

    if (!empty($_POST['language'])) {
      array_push($filters, $_POST['language']);
    }

    if (!empty($_POST['database'])) {
      array_push($filters, $_POST['database']);
    }

    if (!empty($_POST['tag'])) {
      array_push($filters, $_POST['tag']);
    }

    $projects = !empty($filters) ? Project::filterProjects($filters, $projects) : $projects;
    $posts = !empty($filters) ? Post::filterPosts($filters, $posts) : $posts;
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
                  <p class="projects__row-content-desc"><?php echo substr("{$p->getContent()}", 0, 170) . '...' ?></p>
                  <div class="buttons-container">
                    <a href="./post.php?post_id=<?php echo $postId ?>" class="btn btn--med btn--theme dynamicBgClr">Read more</a>
                    <?php if (isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == 'admin') { ?>
                      <a href="./create_post.php?post_id=<?php echo $postId ?>" class="btn btn--med btn--theme-inv">Edit</a>
                      <a href="./delete_post_proc.php?post_id=<?php echo $postId ?>" onclick="return confirm('Are you sure you want to delete the post?')" class="btn btn--med btn--theme-inv">Delete</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </section>
  <?php } else { ?>
    <h3 class="projects__row-content-title heading-sec__main">No search criteria chosen</h3>
  <?php } ?>

  <?php include "includes/footer.php";  ?>
</body>

</html>

<script>
  function onSelectChange() {
    document.getElementById("search_form").submit();
  }
</script>

<?php
include 'includes/scripts.php';
// exit();
?>