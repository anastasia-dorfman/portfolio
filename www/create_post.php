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

// Check if we're editing an existing post
if ($postId != -1) {
    $post = Post::getPostById($postId);
    if ($post) {
        $title = $post->getTitle();
        $content = $post->getContent();
        $tags = implode(', ', $post->getTags());
        $avatar = $post->getAvatar();
        $imageUrls = implode(', ', $post->getImages());
        $editing = true;
    } else {
        setFeedbackAndRedirect("Invalid post ID", "error");
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
                <form action="create_post_proc.php" method="POST" class="contact__form" enctype="multipart/form-data">
                    <input type="hidden" name="postId" value="<?php echo $postId ?>">
                    <input type="hidden" name="isEdit" value="<?php echo $editing ?>">
                    <input type="hidden" name="upload">
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="title">Title</label>
                        <input required type="text" class="contact__form-input" name="title" id="title" placeholder="Title" value="<?php echo $title ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="content">Content</label>
                        <textarea required cols="40" rows="15" class="contact__form-input" name="content" id="content" 
                        placeholder="Content"><?php echo $content ?></textarea>
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="tags">Tags</label>
                        <input required type="text" class="contact__form-input" name="tags" id="tags" placeholder="Tags (comma-separated)" value="<?php echo $tags; ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="avatar">Avatar</label>
                        <input type="file" class="contact__form-input" name="avatar" id="avatar"/>
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="image">Image 1</label>
                        <input type="file" class="contact__form-input" name="image[]" id="image" accept="image/*" />
                        <div id="image-container"></div>
                        <div class="btn-margin">
                            <button type="button" class="btn btn--med" onclick="addImageField()">Add Image</button>
                        </div>
                    </div>
                    <input type="submit" class="btn btn--theme contact__btn" name="createEditPost" value="<?php echo $editing ? 'Update Post' : 'Create Post'; ?>">
                </form>
            </div>
        </div>
    </div>

    <?php
    include "includes/footer.php";
    ?>
    <script src="./index.js"></script>
</body>

</html>

<?php
include 'includes/scripts.php';
?>

<script>
    function addImageField() {
        // Get the container that will hold the new file input field
        const container = document.getElementById("image-container");
        // Create a new div element to hold the file input field
        const div = document.createElement("div");
        // div.className = "upload-field";
        // Create a new label element for the file input field
        const label = document.createElement("label");
        label.className = "contact__form-label";
        label.innerHTML = `Image ${container.children.length + 2}`;
        // Create a new file input element
        const input = document.createElement("input");
        input.required = true;
        input.type = "file";
        input.className = "contact__form-input";
        input.name = "image[]";
        input.accept = "image/*";
        // Append the label and input elements to the new div element
        div.appendChild(label);
        div.appendChild(input);
        // Append the new div element to the container
        container.appendChild(div);
    }
</script>