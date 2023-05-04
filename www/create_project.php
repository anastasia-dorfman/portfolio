<?php

session_start();

include_once "includes/functions.php";
include_once "includes/Project.php";

$projectId = -1;

if (isset($_GET['project_id']) && !empty($_GET['project_id']))
    $projectId = $_GET['project_id'];

$_SESSION["REFERER"] = $projectId === -1 ? "create_project.php" : "create_project.php?project_id=$projectId";

if (!(isset($_SESSION["USERNAME"]))) {
    header("Location: login.php");
    exit;
}

$name = '';
$description = '';
$overview = '';
$tags = '';
$avatar = '';
$imageUrls = '';
$editing = false;
$imagesCount = 0;

if ($projectId != -1) {
    $project = Project::getProjectById($projectId);
    if ($project) {
        $name = $project->getName();
        $description = $project->getDescription();
        $overview = $project->getOverview();
        $tags = implode(', ', $project->getTags());
        $avatar = $project->getFirstImage($projectId);
        $images = $project->getImages();
        $imagesCount = $images == null ? 0 : count($images);
        $imageUrls = implode(', ', $project->getImages());
        $editing = true;
    } else {
        setFeedbackAndRedirect("Invalid project ID", "error", "index#projects.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $editing ? 'Edit Project' : 'Create Project' ?></title>
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700;900&display=swap" rel="stylesheet">
    <script src="includes/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "#content",
            height: 600,
            plugins: "advlist autolink lists link image charmap print preview anchor",
            toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
    </script>
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div id="contact" class="contact sec-pad dynamicBg">
        <div class="main-container">
            <h2>
                <span class="heading-sec__main heading-sec__main--lt"><?php echo $editing ? 'Edit Project' : 'Create Project'; ?></span>
            </h2>
            <div class="post__form-container">
                <form action="create_post_proc.php" method="POST" id="remove_image"></form>
                <form action="create_post_proc.php" method="POST" id="remove_avatar"></form>
                <form action="create_post_proc.php" method="POST" class="contact__form" enctype="multipart/form-data">
                    <input type="hidden" name="projectId" value="<?php echo $projectId ?>">
                    <input type="hidden" name="isEdit" value="<?php echo $editing ?>">
                    <!-- <input type="hidden" name="upload"> -->
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="title">Title</label>
                        <input required type="text" class="contact__form-input" name="title" id="title" placeholder="Title" value="<?php echo $title ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="content">Content</label>
                        <textarea required cols="40" rows="30" class="contact__form-input tiny-mce" name="content" id="content" placeholder="Content"><?php echo $content ?></textarea>
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="tags">Tags</label>
                        <input required type="text" class="contact__form-input" name="tags" id="tags" placeholder="Tags (comma-separated)" value="<?php echo $tags; ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="avatar">Avatar</label>
                        <?php
                        if ($projectId != -1 && $project != null && $project->getAvatar() != null) {
                        ?>
                            <div class="contact__form-input">
                                <img src="<?php echo $project->getAvatar() ?>" alt="Avatar" class="post__avatar" />
                                <!-- <form action="create_post_proc.php" method="POST"> -->
                                <input type="hidden" name="projectId" value="<?php echo $projectId ?>" form="remove_avatar">
                                <input type="hidden" name="link" value="<?php echo $project->getAvatar() ?>" form="remove_avatar">
                                <button type="submit" class="btn btn--med" class="header__link" name="removeImage" form="remove_avatar">Remove/Update</button>
                                <!-- </form> -->
                            </div>
                        <?php
                        }
                        ?>
                        <?php
                        if ($projectId == -1 || $project == null || $project->getAvatar() == null) {
                        ?>
                            <input required type="file" class="contact__form-input" name="avatar" id="avatar" />
                        <?php
                        }
                        ?>
                    </div>
                    <div class="contact__form-field">
                        <?php if ($projectId != -1 && $imageUrls != '') { ?>
                            <label class="contact__form-label" for="image">Images</label>
                            <div class="image-grid">
                                <?php for ($i = 1; $i <= $imagesCount; $i++) { ?>
                                    <div class="contact__form-input fixed-height">
                                        <img src="<?php echo $images[$i - 1] ?>" alt="Image <?php echo $i ?>" />
                                        <div class="mt-auto">
                                            <!-- <form action="remove_image.php" method="POST"> -->
                                            <input type="hidden" name="projectId" value="<?php echo $projectId ?>" form="remove_image">
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
                        <?php if ($projectId == -1 || $imageUrls == '') { ?>
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