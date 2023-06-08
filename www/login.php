<?php
session_start();

$referer = isset($_SESSION["REFERER"]) ? $_SESSION["REFERER"] : "index.php";

// Check if the user is already logged in
if (isset($_SESSION['USERNAME'])) {
    header("Location: $referer");
    exit();
}

$headTitle = "Login";
$metaContent = "Anastasia Dorfman's portfolio website, full stack developer";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include "includes/head.php"; ?>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div id="login" class="contact sec-pad">
        <h2 class="heading heading-sec heading-sec__login">
            <span class="heading-sec__main heading-sec__main--lt">Login</span>

            <?php if (isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>

            <span class="heading-sec__sub heading-sec__sub--lt">
                Please enter your credentials to access your account.
            </span>
        </h2>
        <div class="login__form-container">
            <form action="login_proc.php" method="POST" class="contact__form">
                <div class="contact__form-field">
                    <label class="contact__form-label" for="username">Username</label>
                    <input required placeholder="Enter Your Username" type="text" class="contact__form-input" name="username" id="username" />
                </div>
                <div class="contact__form-field">
                    <label class="contact__form-label" for="password">Password</label>
                    <input required placeholder="Enter Your Password" type="password" class="contact__form-input" name="password" id="password" />
                </div>
                <button type="submit" class="btn btn--theme contact__btn">
                    Login
                </button>
            </form>
        </div>
    </div>
    
    <?php
    // Check if the login form was submitted
    if (isset($_POST['submit'])) {
        try {
            if (!empty($_POST["username"]) && !empty($_POST["password"])) {
                $username = $_POST['username'];
                $_SESSION["USERNAME"] = $username;
                $formPassword = $_POST['password'];

                login($username, $formPassword);
            } else {
                setFeedbackAndRedirect("Fields cannot be empty", "error", "login.php");
            }
        } catch (Exception $ex) {
            setFeedbackAndRedirect("Something went wrong:\n" . $ex->getMessage(), "error", "login.php");
        }
    }
    ?>

    <?php
    include "includes/footer.php";
    ?>
</body>
</html>

<?php
include 'includes/scripts.php';
?>