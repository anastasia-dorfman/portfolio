<?php
// session_start();
?>
<header class="header">
  <div class="header__content">
    <div class="header__logo-container">
      <div class="header__logo-img-cont">
        <img src="./assets/icons/anastasia-dorfman.png" alt="Anastasia Dorfman Logo Image" class="header__logo-img" />
      </div>
      <span class="header__logo-sub">Anastasia Dorfman</span>
    </div>
    <div class="header__main">
      <ul class="header__links">
        <li>
          <a href="./index.php" class="header__link"> Home </a>
        </li>
        <li>
          <a href="./index.php#about" class="header__link">About </a>
        </li>
        <li>
          <a href="./index.php#projects" class="header__link">Projects </a>
        </li>
        <li>
          <a href="./blog.php" class="header__link">Blog </a>
        </li>
        <li class="header__link-wrapper">
          <a href="./index.php#contact" class="header__link"> Contact </a>
        </li>
        <li class="header__search">
          <?php
          if (!isset($_SESSION['USERNAME'])) {
          ?>
            <a href="./login.php" class="header__link" title="Login">
              <img src="assets/svg/login.svg" alt="Login" class="header__search-icon" />
            </a>
          <?php
          } else {
          ?>
            <a href="./logout_proc.php" class="header__link" title="Logout">
              <img src="assets/svg/logout.svg" alt="Logout" class="header__search-icon" />
            </a>
          <?php
          }
          ?>
        </li>
        <li class="header__search">
          <form action="search.php" method="POST" role="search">
            <input type="text" name="search_query" placeholder="Search..." class="header__search-input" />
            <button type="submit" name="search_btn" class="header__search-button" aria-label="Search">
              <img src="assets/svg/search.svg" alt="Search" class="header__search-icon" />
            </button>
          </form>
        </li>
      </ul>

      <div class="header__main-ham-menu-cont">
        <img src="./assets/svg/ham-menu.svg" alt="hamburger menu" class="header__main-ham-menu" />
        <img src="./assets/svg/ham-menu-close.svg" alt="hamburger menu close" class="header__main-ham-menu-close d-none" />
      </div>
    </div>
  </div>
  <div class="header__sm-menu">
    <div class="header__sm-menu-content">
      <ul class="header__sm-menu-links">
        <li class="header__sm-menu-link">
          <a href="./index.php"> Home </a>
        </li>
        <li class="header__sm-menu-link">
          <a href="./index.php#about"> About </a>
        </li>
        <li class="header__sm-menu-link">
          <a href="./index.php#projects"> Projects </a>
        </li>
        <li class="header__sm-menu-link">
          <a href="./blog.php"> Blog </a>
        </li>
        <li class="header__sm-menu-link">
          <a href="./index.php#contact"> Contact </a>
        </li>
        <li class="header__sm-menu-link">
          <a href="./index.php#contact"> Contact </a>
          <?php if (!isset($_SESSION['USERNAME'])) { ?>
            <a href="./login.php" class="header__link"> Login </a>
          <?php } else { ?>
            <a href="./logout_proc.php" class="header__link"> Logout </a>
          <?php } ?>
        </li>
        <li class="header__sm-menu-link">
          <a href="./search.php"> Search </a>
        </li>
      </ul>
    </div>
  </div>
</header>

<script>
  // ---
  const hamMenuBtn = document.querySelector('.header__main-ham-menu-cont')
  const smallMenu = document.querySelector('.header__sm-menu')
  const headerHamMenuBtn = document.querySelector('.header__main-ham-menu')
  const headerHamMenuCloseBtn = document.querySelector(
    '.header__main-ham-menu-close'
  )
  const headerSmallMenuLinks = document.querySelectorAll('.header__sm-menu-link')

  hamMenuBtn.addEventListener('click', () => {
    if (smallMenu.classList.contains('header__sm-menu--active')) {
      smallMenu.classList.remove('header__sm-menu--active')
    } else {
      smallMenu.classList.add('header__sm-menu--active')
    }
    if (headerHamMenuBtn.classList.contains('d-none')) {
      headerHamMenuBtn.classList.remove('d-none')
      headerHamMenuCloseBtn.classList.add('d-none')
    } else {
      headerHamMenuBtn.classList.add('d-none')
      headerHamMenuCloseBtn.classList.remove('d-none')
    }
  })

  for (let i = 0; i < headerSmallMenuLinks.length; i++) {
    headerSmallMenuLinks[i].addEventListener('click', () => {
      smallMenu.classList.remove('header__sm-menu--active')
      headerHamMenuBtn.classList.remove('d-none')
      headerHamMenuCloseBtn.classList.add('d-none')
    })
  }

  // ---
  const headerLogoConatiner = document.querySelector('.header__logo-container')

  headerLogoConatiner.addEventListener('click', () => {
    location.href = 'index.php'
  })
</script>