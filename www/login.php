<?php
// Start session
session_start();

$referer = isset($_SESSION["REFERER"]) ? $_SESSION["REFERER"] : "index.php";

// Check if the user is already logged in
if (isset($_SESSION['USER_ID'])) {
    // Redirect to protected page
    header("Location: $referer");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="includes/css/style.css">
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
            <form action="#" class="contact__form">
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
        // Get the username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the username and password are valid
        if ($username == 'admin' && $password == 'password') {
            // Authentication successful, set session variables and redirect to protected page
            $_SESSION['username'] = $username;
            header("Location: protected.php");
            exit();
        } else {
            // Authentication failed, display error message
            $error = "Invalid username or password";
        }
    }
    ?>

    <?php include "includes/footer.php"; ?>
</body>

</html>