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
  <section class="home-hero">
    <div class="home-hero__content">
      <h1 class="heading-primary">Hey, My name is Anastasia Dorfman</h1>
      <div class="home-hero__info">
        <p class="text-primary">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic facilis
          tempora explicabo quae quod deserunt eius sapiente solutions for
          complex problems
        </p>
      </div>
      <div class="home-hero__cta">
        <a href="./#projects" class="btn btn--bg">Projects</a>
      </div>
    </div>
    <div class="home-hero__socials">
      <div class="home-hero__social">
        <a href="https://www.linkedin.com/in/anastasiadorfman/" class="home-hero__social-icon-link">
          <img src="./assets/icons/linkedin-ico.png" alt="icon" class="home-hero__social-icon" />
        </a>
      </div>
      <div class="home-hero__social">
        <a href="https://github.com/anastasia-dorfman" class="home-hero__social-icon-link">
          <img src="./assets/icons/github-ico.png" alt="icon" class="home-hero__social-icon" />
        </a>
      </div>
    </div>
    <div class="home-hero__mouse-scroll-cont">
      <div class="mouse"></div>
    </div>
  </section>
  <section id="about" class="about sec-pad">
    <div class="main-container">
      <h2 class="heading heading-sec heading-sec__mb-med">
        <span class="heading-sec__main">About Me</span>
        <span class="heading-sec__sub">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic facilis
          tempora explicabo quae quod deserunt eius sapiente
        </span>
      </h2>
      <div class="about__content">
        <div class="about__content-main">
          <h3 class="about__content-title">Get to know me!</h3>
          <div class="about__content-details">
            <p class="about__content-details-para">
              Hey! It's
              <strong>Anastasia Dorfman</strong>
              and I'm a <strong> Frontend Web Developer </strong> located in
              Los Angeles. I've done
              <strong> remote </strong>
              projects for agencies, consulted for startups, and collaborated
              with talented people to create
              <strong>digital products </strong>
              for both business and consumer use.
            </p>
            <p class="about__content-details-para">
              I'm a bit of a digital product junky. Over the years, I've used
              hundreds of web and mobile apps in different industries and
              verticals. Feel free to
              <strong>contact</strong> me here.
            </p>
          </div>
          <a href="./#contact" class="btn btn--med btn--theme dynamicBgClr">Contact</a>
        </div>
        <div class="about__content-skills">
          <h3 class="about__content-title">My Skills</h3>
          <div class="skills">
            <div class="skills__skill">HTML</div>
            <div class="skills__skill">CSS</div>
            <div class="skills__skill">JavaScript</div>
            <div class="skills__skill">React</div>
            <div class="skills__skill">GIT</div>
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