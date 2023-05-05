<?php
session_start();

include_once "includes/functions.php";

$projectId = $_GET['project_id'] ?? -1;
$_SESSION["REFERER"] = "create_project.php" . ($projectId !== -1 ? "?project_id=$projectId" : "");
$referer = $_SESSION["REFERER"];

if (!(isset($_SESSION["USERNAME"]))) {
    header("Location: login.php");
    exit;
}

include_once "includes/Project.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeImage'])) {
        $projectId = $_POST['projectId'];
        $link = $_POST['link'];
        deleteImage($projectId, $link);
        header("Location:create_project.php?project_id=$projectId");
        exit;
    }

    if (isset($_POST['createEditProject'])) {
        $projectId = $_POST['projectId'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $overview = $_POST['overview'];
        $codeLink = $_POST['code_link'];
        $dateCreated = $_POST['created_at'];
        $tags = $_POST['tags'];

        $post = $projectId == -1 ? null : Project::getProjectById($projectId);

        $lastSavedImageIndex = 0;

        if ($post != null) {
            $projectId = Project::updateProject($projectId, $name, $description, $overview, $codeLink, $dateCreated);
            $lastSavedImageIndex = Project::getLastImageIndex($projectId);
        } else {
            $projectId = Project::createProject($name, $description, $overview, $codeLink, $dateCreated);
        }

        Project::updateTags($tags, $projectId);
        uploadFile($projectId, 'avatar', 'avatar');
        uploadFile($projectId, 'image', 'image', $lastSavedImageIndex);

        $project = Project::getProjectById($projectId);

        setFeedbackAndRedirect("Project saved successfully", "success", "post.php?project_id=" . $post->getprojectId());
    }
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", $referer);
}

function uploadFile($projectId, $fileType, $prefix, $lastSavedImageIndex = null,  $fileFieldName = null)
{
    try {
        $fileFieldName = $fileFieldName ?? $fileType;
        $allowedFileTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp', 'image/pjpg', 'image/x-png'];

        if (empty($_FILES[$fileFieldName]['name']) || empty($_FILES[$fileFieldName]['name'][0])) {
            return;
        }

        $total = $lastSavedImageIndex === null ? 1 : count($_FILES[$fileFieldName]['name']);

        for ($i = 0; $i < $total; $i++) {
            $file = $lastSavedImageIndex === null ? $_FILES[$fileFieldName]['tmp_name'] : $_FILES[$fileFieldName]['tmp_name'][$i];
            $file_info = new finfo(FILEINFO_MIME);

            $mime_type_long = $file_info->buffer(file_get_contents($file));
            $intpos = strpos($mime_type_long, ";");
            $mime_type = substr($mime_type_long, 0, $intpos);

            if (in_array($mime_type, $allowedFileTypes)) {
                $pathinfo = pathinfo($_FILES[$fileFieldName]['name'][$i]);
                $basenameIndex = $fileType == 'avatar' ? null : $i + $lastSavedImageIndex + 1;
                $basename = "post" . $projectId . "_" . $prefix . $basenameIndex ?? '' . "." . $pathinfo['extension'];
                $basenameNoExtension = "post" . $projectId . "_" . $prefix . $basenameIndex ?? '';

                $imginfo_array = getimagesize($file);

                if ($imginfo_array !== false) {
                    $uploaddir = './assets/images/';
                    $uploadfile = $uploaddir . $basename;

                    foreach (glob($uploaddir . $basenameNoExtension . '.*') as $filename) {
                        unlink($filename);
                    }

                    // if (file_exists($uploadfile)) {
                    //     unlink($uploadfile);
                    // }

                    if (move_uploaded_file($file, $uploadfile)) {
                        if (!Project::updateImage($uploadfile, $basename, $projectId, $basenameNoExtension)) {
                            setFeedbackAndRedirect("Post created, but there was an Error uploading image(s)", "error");
                        }
                    } else {
                        setFeedbackAndRedirect("Invalid File, malicious attack perhaps?", "error");
                    }
                }
            } else {
                setFeedbackAndRedirect("Incorrect mime type: " . $mime_type_long, "error");
            }
        }
    } catch (Exception $ex) {
        setFeedbackAndRedirect($ex->getMessage(), "error");
    }
}

function deleteImage($projectId, $imagePath)
{
    if (file_exists($imagePath)) {
        unlink($imagePath);
        Project::removeImage($projectId, $imagePath);
        return true;
    } else {
        return false;
    }
}
