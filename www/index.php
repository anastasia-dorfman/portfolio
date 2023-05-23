<?php
session_start();

include_once "includes/functions.php";
include_once "includes/Project.php";
include_once "includes/Post.php";

$_SESSION["REFERER"] = "index.php";

$projects = Project::getProjects();

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
  <?php
  include "includes/header.php";

  $_SESSION["REFERER"] = "index.php";

  ?>
  <section class="home-hero">
    <div class="home-hero__content">
      <h1 class="heading-primary">Hey, My name is Anastasia Dorfman</h1>
      <div class="home-hero__info">
        <p class="text-primary">
          As an entry-level full stack developer, I am committed to staying up-to-date with the latest technologies and industry trends,
          enabling me to bring fresh ideas and innovative approaches and deliver high-quality web solutions
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
          Passionate senior IT student with a diverse skill set in web development and a constant drive for learning and innovation
        </span>
      </h2>
      <div class="about__content">
        <div class="relative_position">
          <div class="about__content-main">
            <h3 class="about__content-title">Get to know me!</h3>
            <div class="about__content-details">
              <p class="about__content-details-para">
                Hey! I'm <strong>Anastasia Dorfman</strong> , a senior IT student with a passion for <strong> web development </strong>. I am
                located in Moncton, NB, Canada, but open to relocation for the right opportunity.
                I always seek to expand my knowledge and stay up-to-date with industry trends and best practices.
              </p>
              <p class="about__content-details-para">
                I'm excited to connect with potential employers and create efficient and secure web solutions that meet their needs.
                Feel free to <strong>contact</strong> me here.
              </p>
            </div>
            <a href="./#contact" class="btn btn--med btn--theme dynamicBgClr">Contact</a>
          </div>
        </div>
        <div class="relative_position">
          <div class="about__content-skills">
            <h3 class="about__content-title">My Skills</h3>
            <?php getSkills(); ?>
          </div>
          <a href="assets/docs/Resume_AnastasiaDorfman.pdf" class="btn btn--med btn--theme dynamicBgClr">Get the Resume</a>
        </div>
      </div>
    </div>
  </section>
  <section id="projects" class="projects sec-pad">
    <div class="main-container">
      <h2 class="heading heading-sec heading-sec__mb-bg">
        <span class="heading-sec__main">Projects</span>
        <span class="heading-sec__sub">
          Check out some of my latest projects and see how I can turn your web development ideas into reality
        </span>
        <?php if (isset($_SESSION["USER_TYPE"]) && $_SESSION["USER_TYPE"] == 'admin') { ?>
          <div class="btn__margin">
            <a href="./create_project.php" class="btn btn--med btn--theme-inv">Create Project</a>
          </div>
        <?php } ?>
      </h2>
      <?php foreach ($projects as $p) {
        $projectId = $p->getProjectId(); ?>
        <div class="projects__content">
          <div class="projects__row">
            <div class="projects__row-img-cont">
              <img src="<?php echo $p->getAvatar(); ?>" alt="Software Screenshot" class="projects__row-img" loading="lazy" />
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
    </div>
  </section>
  <section id="contact" class="contact sec-pad dynamicBg">
    <div class="main-container">
      <h2 class="heading heading-sec heading-sec__mb-med">
        <span class="heading-sec__main heading-sec__main--lt">Contact</span>
        <span class="heading-sec__sub heading-sec__sub--lt">
          Let's collaborate and create innovative web solutions together. Contact me today to discuss your project!
        </span>
      </h2>
      <div class="contact__form-container">
        <form action="send_message_proc.php" class="contact__form" method="POST">
          <div class="contact__form-field">
            <label class="contact__form-label" for="name">Name</label>
            <input required placeholder="Enter Your Name" type="text" class="contact__form-input" name="name" id="name" />
          </div>
          <div class="contact__form-field">
            <label class="contact__form-label" for="email">Email</label>
            <input required placeholder="Enter Your Email" type="text" class="contact__form-input" name="email" id="email" />
          </div>
          <div class="contact__form-field">
            <label class="contact__form-label" for="message">Message</label>
            <textarea required cols="30" rows="10" class="contact__form-input" placeholder="Enter Your Message" name="message" id="message"></textarea>
          </div>
          <button type="submit" class="btn btn--theme contact__btn">
            Submit
          </button>
        </form>
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