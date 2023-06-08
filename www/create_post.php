<?php

session_start();

include_once "includes/functions.php";
include_once "includes/Post.php";

$postId = -1;

if (isset($_GET['post_id']) && !empty($_GET['post_id']))
    $postId = $_GET['post_id'];

$_SESSION["REFERER"] = $postId === -1 ? "create_post.php" : "create_post.php?post_id=$postId";

if (!(isset($_SESSION["USERNAME"]))) {
    header("Location: login.php");
    exit;
}

// Initialize variables for the post form
$title = '';
$content = '';
$tags = '';
$avatar = '';
$imageUrls = '';
$editing = false;
$imagesCount = 0;
$maxFileSize = 2 * 1024 * 1024;

// Check if we're editing an existing post
if ($postId != -1) {
    $post = Post::getPostById($postId);
    if ($post) {
        $title = $post->getTitle();
        $content = $post->getContent();
        $tags = implode(', ', $post->getTags());
        $avatar = $post->getAvatar();
        $images = $post->getImages();
        $imagesCount = $images == null ? 0 : count($images);
        $imageUrls = implode(', ', $post->getImages());
        $editing = true;
    } else {
        setFeedbackAndRedirect("Invalid post ID", "error", "blog.php");
    }
}

$headTitle = $editing ? 'Edit Post' : 'Create Post';
$metaContent = "Create a new post for the blog";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head.php"; ?>
    <script src="includes/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "#content",
            height: 600,
            plugins: "advlist autolink lists link image charmap preview anchor",
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div id="contact" class="contact sec-pad dynamicBg">
        <div class="main-container">
            <h2>
                <span class="heading-sec__main heading-sec__main--lt mt-4"><?php echo $editing ? 'Edit Post' : 'Create Post'; ?></span>
            </h2>
            <div class="post__form-container">
                <?php if ($postId != -1 && $post != null && $post->getAvatar() != null) { ?>
                    <form action="create_post_proc.php" method="POST" id="remove_avatar"></form>
                <?php } ?>
                <?php if ($postId != -1 && $imageUrls != '') { ?>
                    <form action="create_post_proc.php" method="POST" id="remove_image"></form>
                <?php } ?>
                <form action="create_post_proc.php" method="POST" class="contact__form" enctype="multipart/form-data">
                    <input type="hidden" name="postId" value="<?php echo $postId ?>">
                    <input type="hidden" name="isEdit" value="<?php echo $editing ?>">
                    <!-- <input type="hidden" name="upload"> -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxFileSize ?>">
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="title">Title</label>
                        <input required type="text" class="contact__form-input" name="title" id="title" placeholder="Title" value="<?php echo $title ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="content">Content</label>
                        <textarea cols="40" rows="30" class="contact__form-input tiny-mce" name="content" id="content" placeholder="Content"><?php echo $content ?></textarea>
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="tags">Tags</label>
                        <input required type="text" class="contact__form-input" name="tags" id="tags" placeholder="Tags (comma-separated)" value="<?php echo $tags; ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="avatar">Avatar</label>
                        <?php if ($postId != -1 && $post != null && $post->getAvatar() != null) { ?>
                            <div class="contact__form-input">
                                <img src="<?php echo $post->getAvatar() ?>" alt="Avatar" class="post__avatar" />
                                <!-- <form action="create_post_proc.php" method="POST"> -->
                                <input type="hidden" name="postId" value="<?php echo $postId ?>" form="remove_avatar">
                                <input type="hidden" name="link" value="<?php echo $post->getAvatar() ?>" form="remove_avatar">
                                <button type="submit" class="btn btn--med" class="header__link" name="removeImage" form="remove_avatar">Remove/Update</button>
                                <!-- </form> -->
                            </div>
                        <?php } ?>
                        <?php if ($postId == -1 || $post == null || $post->getAvatar() == null) { ?>
                            <input required type="file" class="contact__form-input" name="avatar" id="avatar" />
                        <?php } ?>
                    </div>
                    <div class="contact__form-field">
                        <?php if ($postId != -1 && $imageUrls != '') { ?>
                            <label class="contact__form-label" for="image">Images</label>
                            <div class="image-grid">
                                <?php for ($i = 1; $i <= $imagesCount; $i++) { ?>
                                    <div class="contact__form-input fixed-height">
                                        <img src="<?php echo $images[$i - 1] ?>" alt="Image <?php echo $i ?>" />
                                        <div class="mt-auto">
                                            <!-- <form action="remove_image.php" method="POST"> -->
                                            <input type="hidden" name="postId" value="<?php echo $postId ?>" form="remove_image">
                                            <input type="hidden" name="link" value="<?php echo $images[$i - 1] ?>" form="remove_image">
                                            <button type="submit" class="btn btn--med" name="removeImage" form="remove_image">Remove</button>
                                            <!-- </form> -->
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="contact__form-field">
                        <?php if ($postId == -1 || $imageUrls == '') { ?>
                            <label class="contact__form-label" for="image">Image <?php echo ($imagesCount + 1) ?> </label>
                            <input type="file" class="contact__form-input" name="image[]" id="image" accept="image/*" />
                        <?php } ?>
                        <div id="image-container"></div>
                        <div class="btn-margin">
                            <button type="button" class="btn btn--med" id="addImage">Add Image</button>
                        </div>
                    </div>
                    <input type="submit" class="btn btn--theme contact__btn" name="createEditPost" value="<?php echo $editing ? 'Update Post' : 'Create Post'; ?>">
                </form>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>
    <?php include 'includes/scripts.php'; ?>
</body>

</html>