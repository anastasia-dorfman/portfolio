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

$tools = Project::getAllTools();

date_default_timezone_set('America/Halifax');
$currentTime = new DateTime();
$currentTime->setTimestamp(time());
$currentTime = $currentTime->format('Y-m-d');

$name = '';
$description = '';
$overview = '';
$codeLink = '';
$dateCreated = $currentTime;
$tags = [];
$avatar = '';
$editing = false;
$imagesCount = 0;
$maxFileSize = 2 * 1024 * 1024;

if ($projectId != -1) {
    $project = Project::getProjectById($projectId);
    if ($project) {
        $name = $project->getName();
        $description = $project->getDescription();
        $overview = $project->getOverview();
        $codeLink = $project->getCodeLink();
        $dateCreated = new DateTime($project->getDateCreated());
        $dateCreated = $dateCreated->format('Y-m-d');;
        $tags = $project->getTags();
        $avatar = $project->getAvatar();
        $images = $project->getImages();
        $imagesCount = $images == null ? 0 : count($images);
        $editing = true;
    } else {
        setFeedbackAndRedirect("Invalid project ID", "error", "index#projects.php");
    }
}

$headTitle = $editing ? 'Edit Project' : 'Create Project';
$metaContent = "Create a new post for the blog";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "includes/head.php"; ?>
    <script src="includes/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: "#overview",
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
                <span class="heading-sec__main heading-sec__main--lt mt-4"><?php echo $editing ? 'Edit Project' : 'Create Project'; ?></span>
            </h2>
            <div class="post__form-container">
                <form action="create_project_proc.php" method="POST" id="remove_image"></form>
                <form action="create_project_proc.php" method="POST" id="remove_avatar"></form>
                <form action="create_project_proc.php" method="POST" class="contact__form" enctype="multipart/form-data">
                    <input type="hidden" name="project_id" value="<?php echo $projectId ?>">
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxFileSize ?>">
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="name">Name</label>
                        <input required type="text" class="contact__form-input" name="name" id="name" placeholder="Name" value="<?php echo $name ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="description">Description</label>
                        <input required type="text" class="contact__form-input" name="description" id="description" placeholder="Description" value="<?php echo $description ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="overview">Overview</label>
                        <textarea cols="40" rows="30" class="contact__form-input tiny-mce" name="overview" id="overview" placeholder="Overview"><?php echo $overview ?></textarea>
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="code_link">Code Link</label>
                        <input required type="text" class="contact__form-input" name="code_link" id="code_link" placeholder="Code Link" value="<?php echo $codeLink ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label" for="created_at">Date Created</label>
                        <input required type="date" class="contact__form-input" name="created_at" id="created_at" max="<?php echo $currentTime ?>" value="<?php echo $dateCreated ?>" />
                    </div>
                    <div class="contact__form-field">
                        <label class="contact__form-label">Tools Used</label>
                        <div class="tools-container">
                            <?php foreach ($tools as $t) { ?>
                                <div class="tools-checkbox">
                                    <input type="checkbox" name="tags[]" value="<?php echo $t ?>" <?php if (in_array($t, $tags)) {
                                                                                                        echo 'checked="checked"';
                                                                                                    } ?>>
                                    <?php echo $t ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="contact__form-field">
                        <label class="contact__form-label" for="avatar">Main image</label>
                        <?php if ($projectId != -1 && $project != null && $avatar != null) { ?>
                            <div class="contact__form-input">
                                <img src="<?php echo $avatar ?>" alt="Avatar" class="post__avatar" />
                                <input type="hidden" name="project_id" value="<?php echo $projectId ?>" form="remove_avatar">
                                <input type="hidden" name="link" value="<?php echo $avatar ?>" form="remove_avatar">
                                <button type="submit" class="btn btn--med" class="header__link" name="removeImage" form="remove_avatar">Remove/Update</button>
                            </div>
                        <?php } else { ?>
                            <input required type="file" class="contact__form-input" name="avatar" id="avatar" />
                        <?php } ?>
                    </div>
                    <div class="contact__form-field">
                        <?php if ($projectId != -1 && $images != null) { ?>
                            <label class="contact__form-label" for="image">Images</label>
                            <div class="image-grid">
                                <?php for ($i = 1; $i <= $imagesCount; $i++) { ?>
                                    <div class="contact__form-input fixed-height">
                                        <img src="<?php echo $images[$i - 1] ?>" alt="Image <?php echo $i ?>" />
                                        <div class="mt-auto">
                                            <input type="hidden" name="project_id" value="<?php echo $projectId ?>" form="remove_image">
                                            <input type="hidden" name="link" value="<?php echo $images[$i - 1] ?>" form="remove_image">
                                            <button type="submit" class="btn btn--med" name="removeImage" form="remove_image">Remove</button>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="contact__form-field">
                        <?php if ($projectId == -1 || $images == null) { ?>
                            <label class="contact__form-label" for="image">Image <?php echo ($imagesCount + 1) ?> </label>
                            <input required type="file" class="contact__form-input" name="image[]" id="image" accept="image/*" />
                        <?php } ?>
                        <div id="image-container"></div>
                        <div class="btn-margin">
                            <button type="button" class="btn btn--med" id="addImage">Add Image</button>
                        </div>
                    </div>
                    <input type="submit" class="btn btn--theme contact__btn" name="createEditProject" value="<?php echo $editing ? 'Update Project' : 'Create Project'; ?>">
                </form>
            </div>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>

<?php include 'includes/scripts.php'; ?>