<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Case Study of Project 1</title>
  <meta name="description" content="Case study page of Project" />

  <link rel="stylesheet" href="includes/css/style.css" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700;900&display=swap" rel="stylesheet" />
</head>

<body>
  <?php
  include "includes/header.php";
  include "includes/functions.php";
  ?>
  <section class="project-cs-hero">
    <div class="project-cs-hero__content">
      <h1 class="heading-primary">Project 1</h1>
      <div class="project-cs-hero__info">
        <p class="text-primary">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos
          in numquam incidunt earum quaerat cum fuga, atque similique natus
          nobis sit.
        </p>
      </div>
      <div class="project-cs-hero__cta">
        <a href="#" class="btn btn--bg" target="_blank">Live Link</a>
      </div>
    </div>
  </section>
  <section class="project-details">
    <div class="main-container">
      <div class="project-details__content">
        <div class="project-details__showcase-img-cont">
          <img src="./assets/images/project-mockup-example.jpeg" alt="Project Image" class="project-details__showcase-img" />
        </div>
        <div class="project-details__content-main">
          <div class="project-details__desc">
            <h3 class="project-details__content-title">Project Overview</h3>
            <p class="project-details__desc-para">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque
              alias tenetur minus quaerat aliquid, aut provident blanditiis,
              deleniti aspernatur ipsam eaque veniam voluptatem corporis vitae
              mollitia laborum corrupti ullam rem. Lorem ipsum dolor sit amet
              consectetur adipisicing elit. Neque alias tenetur minus quaerat
              aliquid, aut provident blanditiis, deleniti aspernatur ipsam
              eaque veniam voluptatem corporis vitae mollitia laborum corrupti
              ullam rem?
            </p>
            <p class="project-details__desc-para">
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque
              alias tenetur minus quaerat aliquid, aut provident blanditiis,
              deleniti aspernatur ipsam eaque veniam voluptatem corporis vitae
              mollitia laborum corrupti ullam rem?
            </p>
          </div>
          <div class="project-details__tools-used">
            <h3 class="project-details__content-title">Tools Used</h3>
            <div class="skills">
              <div class="skills__skill">HTML</div>
              <div class="skills__skill">CSS</div>
              <div class="skills__skill">JavaScript</div>
              <div class="skills__skill">React</div>
              <div class="skills__skill">SASS</div>
              <div class="skills__skill">GIT</div>
              <div class="skills__skill">Shopify</div>
              <div class="skills__skill">Wordpress</div>
              <div class="skills__skill">Google ADS</div>
              <div class="skills__skill">Facebook Ads</div>
              <div class="skills__skill">Android</div>
              <div class="skills__skill">IOS</div>
            </div>
          </div>
          <div class="project-details__links">
            <h3 class="project-details__content-title">See Live</h3>
            <a href="#" class="btn btn--med btn--theme project-details__links-btn" target="_blank">Live Link</a>
            <a href="#" class="btn btn--med btn--theme-inv project-details__links-btn" target="_blank">Code Link</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <?php
  include "includes/footer.php";
  ?>
  <script src="./index.js"></script>
</body>

</html>

<?php
include 'includes/scripts.php';
?>