<?php
session_start();

include_once "includes/functions.php";

$postId = $_GET['post_id'] ?? -1;

if (!(isset($_SESSION["USERNAME"]))) {
    $_SESSION["REFERER"] = "delete_post_proc.php?post_id=$postId";
    header("Location: login.php");
    exit;
}

include_once "includes/Post.php";

try {
    $post = $postId == -1 ? null : Post::getPostById($postId);

    if ($post != null) {
        Post::deletePost($postId, $post);
    }

    setFeedbackAndRedirect("Post was deleted", "success", "blog.php");
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", "post.php?post_id=$postId");
}
