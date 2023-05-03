<?php

session_start();

include_once "includes/functions.php";
include_once "includes/Project.php";

if (!(isset($_GET['project_id'])) || empty($_GET['project_id'])) {
  setFeedbackAndRedirect("Choose a project to show", "error");
}

$projectId = $_GET['project_id'];

$_SESSION["REFERER"] = "project.php?project_id=" . $projectId;

$project = Project::getProjectById($projectId);
$name = $project->getName();
$description = $project->getDescription();
$overview = $project->getOverview();
$date = $project->getDateCreated();
$codeLink = $project->getCodeLink();
$images = $project->getImages();
$tags = $project->getTags();
$avatar = $project->getFirstImage($projectId);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Case Study of <?php echo $name ?></title>
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
  <section class="project-cs-hero">
    <div class="project-cs-hero__content">
      <h1 class="heading-primary"><?php echo $name ?></h1>
      <div class="project-cs-hero__info">
        <p class="text-primary"><?php echo $description ?></p>
      </div>
      <div class="project-cs-hero__cta">
        <!-- <a href="#" class="btn btn--bg" target="_blank">Live Link</a> -->
        <a href="<?php echo $codeLink ?>" class="btn btn--bg" target="_blank">Code Link</a>
      </div>
    </div>
  </section>
  <section class="project-details">
    <div class="main-container">
      <div class="project-details__content">
        <div class="project-details__showcase-img-cont">
          <img src="./assets/images/project-mockup-example.jpeg" alt="Project Image" class="project-details__showcase-img" />
          <img src="<?php echo $avatar ?>" alt="Project Image" class="project-details__showcase-img" />
        </div>
        <div class="project-details__content-main">
          <div class="project-details__desc">
            <h3 class="project-details__content-title">Project Overview</h3>
            <p class="project-details__desc-para"><?php echo $overview ?></p>
          </div>
          <div class="project-details__tools-used">
            <h3 class="project-details__content-title">Tools Used</h3>
            <div class="skills">
              <?php foreach ($tags as $t) { ?>
                <div class="skills__skill"><?php echo $t ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="project-details__links">
            <!-- <h3 class="project-details__content-title">See Live</h3> -->
            <!-- <a href="#" class="btn btn--med btn--theme project-details__links-btn" target="_blank">Live Link</a> -->
            <a href="<?php echo $codeLink ?>" class="btn btn--med btn--theme-inv project-details__links-btn" target="_blank">Code Link</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php include "includes/footer.php"; ?>
  <script src="./index.js"></script>
</body>

</html>

<?php include 'includes/scripts.php'; ?>