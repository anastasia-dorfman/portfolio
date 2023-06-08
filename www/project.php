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
$avatar = $project->getAvatar();

$headTitle = "Case Study of $name";
$metaContent = "Case study page of Project";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "includes/head.php"; ?>
</head>

<body>
  <?php include "includes/header.php"; ?>
  
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

  <?php
  if (isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == 'admin') {
  ?>
    <div class="btn__margin">
      <a href="./create_project.php?project_id=<?php echo $projectId ?>" class="btn btn--med btn--theme-inv">Edit Project</a>
      <a href="./delete_project_proc.php?project_id=<?php echo $projectId ?>" onclick="showDeleteConfirmation(event)" class="btn btn--med btn--theme-inv">Delete Project</a>
    </div>
  <?php
  }
  ?>

  <section class="project-details">
    <div class="main-container">
      <div class="project-details__content">
        <div class="project-details__showcase-img-cont">
          <a href="<?php echo $avatar ?>" class="lightbox-link">
            <img src="<?php echo $avatar ?>" alt="Project Image" class="project-details__showcase-img" />
          </a>
        </div>
        <div class="project-details__desc">
          <h3 class="project-details__content-title">Project Overview</h3>
          <p class="project-details__desc-para"><?php echo $overview ?></p>
        </div>
        <div class="post__row">
          <?php foreach ($images as $i) { ?>
            <a href="<?php echo $i ?>" class="lightbox-link">
              <img src="<?php echo $i ?>" alt="Project Image" class="project-details__showcase-img post__img" />
            </a>
          <?php } ?>
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
  </section>
  <?php include "includes/footer.php"; ?>


</body>

</html>

<?php include_once 'includes/scripts.php'; ?>