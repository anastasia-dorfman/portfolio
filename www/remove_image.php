<?php
session_start();

include_once "includes/functions.php";
include_once "includes/Post.php";

$_SESSION["REFERER"] = "create_post.php";

if (!(isset($_SESSION["USERNAME"]))) {
    if ($postId != -1)
        $_SESSION["REFERER"] = "create_post.php?post_id=$postId";
    else
        $_SESSION["REFERER"] = "create_post.php";
    exit;

    header("Location: login.php");
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeImage'])) {
        $postId = $_POST['postId'];
        $link = $_POST['link'];
        deleteImage($postId, $link);
        header("Location:create_post.php?post_id=$postId");
    }
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", "create_post.php");
}