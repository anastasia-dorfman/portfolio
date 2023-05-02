<?php

session_start();

include_once "includes/functions.php";
include_once "includes/Post.php";

$_SESSION["REFERER"] = "create_post.php";

$postId = -1;

if (isset($_GET['post_id']) && !empty($_GET['post_id'])) {
    $postId = $_GET['post_id'];
}

if (!(isset($_SESSION["USERNAME"]))) {

    if ($postId != -1)
        $_SESSION["REFERER"] = "create_post.php?post_id=$postId";
    else
        $_SESSION["REFERER"] = "create_post.php";

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $editing ? 'Edit Post' : 'Create Post' ?></title>
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700;900&display=swap" rel="stylesheet">
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div id="contact" class="contact sec-pad dynamicBg">
        <div class="main-container">
            <h2>
                <span class="heading-sec__main heading-sec__main--lt"><?php echo $editing ? 'Edit Post' : 'Create Post'; ?></span>
            </h2>
            <div class="post__form-container">
                <form action="create_post_proc.php" method="POST" id="remove_image"></form>
                <form action="create_post_proc.php" method="POST" id="remove_avatar"></form>
                <form action="create_post_proc.php" method="POST" class="contact__form" enctype="multipart/form-data">
                    <input type="hidden" name="postId" value="<?php echo $postId ?>">
                    <input type="hidden" name="isEdit" value="<?php echo $editing ?>">
                    <!-- <input type="hidden" name="upload"> -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="title">Title</label>
                        <input required type="text" class="contact__form-input" name="title" id="title" placeholder="Title" value="<?php echo $title ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="content">Content</label>
                        <textarea required cols="40" rows="15" class="contact__form-input" name="content" id="content" placeholder="Content"><?php echo $content ?></textarea>
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="tags">Tags</label>
                        <input required type="text" class="contact__form-input" name="tags" id="tags" placeholder="Tags (comma-separated)" value="<?php echo $tags; ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="avatar">Avatar</label>
                        <?php
                        if ($postId != -1 && $post != null && $post->getAvatar() != null) {
                        ?>
                            <div class="contact__form-input">
                                <img src="<?php echo $post->getAvatar() ?>" alt="Avatar" class="post__avatar" />
                                <!-- <form action="create_post_proc.php" method="POST"> -->
                                    <input type="hidden" name="postId" value="<?php echo $postId ?>" form="remove_avatar">
                                    <input type="hidden" name="link" value="<?php echo $post->getAvatar() ?>" form="remove_avatar">
                                    <button type="submit" class="btn btn--med" class="header__link" name="removeImage" form="remove_avatar">Remove/Update</button>
                                <!-- </form> -->
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        if ($postId == -1 || $post == null || $post->getAvatar() == null) {
                        ?>
                            <input type="file" class="contact__form-input" name="avatar" id="avatar" />
                        <?php
                        }
                        ?>
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
    <script src="./index.js"></script>
</body>

</html>

<?php include 'includes/scripts.php'; ?>

<script>
    const addImageButton = document.getElementById("addImage");
    let imageIndex = <?php echo $imagesCount ?>;
    let shift = imageIndex == 0 ? 2 : 1;

    addImageButton.addEventListener("click", function() {
        const container = document.getElementById("image-container");
        const div = document.createElement("div");
        const label = document.createElement("label");
        label.className = "contact__form-label";
        label.innerHTML = `Image ${container.children.length + imageIndex + shift}`;
        const input = document.createElement("input");
        input.required = true;
        input.type = "file";
        input.className = "contact__form-input";
        input.name = "image[]";
        input.accept = "image/*";
        div.appendChild(label);
        div.appendChild(input);
        container.appendChild(div);
    });
</script>