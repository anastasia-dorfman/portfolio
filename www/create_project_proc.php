<?php
session_start();

include_once "includes/functions.php";

$projectId = $_POST['project_id'] ?? -1;
$_SESSION["REFERER"] = "create_project.php" . ($projectId !== -1 ? "?project_id=$projectId" : "");
$referer = $_SESSION["REFERER"];

if (!(isset($_SESSION["USERNAME"]))) {
    header("Location: login.php");
    exit;
}

include_once "includes/Project.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeImage'])) {
        $link = $_POST['link'];
        deleteImage($projectId, $link);
        header("Location:$referer");
        exit;
    }

    if (isset($_POST['createEditProject'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $overview = $_POST['overview'];
        $codeLink = $_POST['code_link'];
        $dateCreated = $_POST['created_at'];
        $tags = $_POST['tags'];

        $project = $projectId == -1 ? null : Project::getProjectById($projectId);

        $lastSavedImageIndex = 0;

        if ($project != null) {
            $projectId = Project::updateProject($projectId, $name, $description, $overview, $codeLink, $dateCreated);
            $lastSavedImageIndex = Project::getLastImageIndex($projectId);
        } else {
            $projectId = Project::createProject($name, $description, $overview, $codeLink, $dateCreated);
        }

        Project::updateTags($tags, $projectId);
        uploadFile($projectId, 'avatar', 'avatar', $referer);
        uploadFile($projectId, 'image', 'image', $referer, $lastSavedImageIndex);

        $project = Project::getProjectById($projectId);

        setFeedbackAndRedirect("Project saved successfully", "success", "project.php?project_id=" . $project->getprojectId());
    }
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", $referer);
}

function uploadFile($projectId, $fileType, $prefix, $referer, $lastSavedImageIndex = null,  $fileFieldName = null)
{
    try {
        $fileFieldName = $fileType;
        $allowedFileTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp', 'image/pjpg', 'image/x-png'];

        if (empty($_FILES[$fileFieldName]['name']) && empty($_FILES[$fileFieldName]['name'][0])) {
            return;
        }

        $total = $lastSavedImageIndex === null ? 1 : count($_FILES[$fileFieldName]['name']);

        for ($i = 0; $i < $total; $i++) {
            $tempFile = $lastSavedImageIndex === null ? $_FILES[$fileFieldName]['tmp_name'] : $_FILES[$fileFieldName]['tmp_name'][$i];
            $file_info = new finfo(FILEINFO_MIME);

            $mime_type_long = $file_info->buffer(file_get_contents($tempFile));
            $intpos = strpos($mime_type_long, ";");
            $mime_type = substr($mime_type_long, 0, $intpos);

            if (in_array($mime_type, $allowedFileTypes)) {
                $file = $lastSavedImageIndex === null ? $_FILES[$fileFieldName]['name'] : $_FILES[$fileFieldName]['name'][$i];
                $pathinfo = pathinfo($file);
                $extension = $pathinfo['extension'];
                $basenameIndex = $fileType == 'avatar' ? null : $i + $lastSavedImageIndex + 1;
                $basenameNoExtension = "project" . $projectId . "_" . $prefix . $basenameIndex ?? '';
                $basename = $basenameNoExtension . ".".$extension;

                $imginfo_array = getimagesize($tempFile);

                if ($imginfo_array !== false) {
                    $uploaddir = './assets/images/';
                    $uploadfile = $uploaddir . $basename;

                    foreach (glob($uploaddir . $basenameNoExtension . '.*') as $filename) {
                        unlink($filename);
                    }

                    if (move_uploaded_file($tempFile, $uploadfile)) {
                        if (!Project::updateImage($uploadfile, $basenameNoExtension, $projectId, $basenameIndex)) {
                            setFeedbackAndRedirect("Post created, but there was an Error uploading image(s)", "error", $referer);
                        }
                    } else {
                        setFeedbackAndRedirect("Invalid File, malicious attack perhaps?", "error", $referer);
                    }
                }
            } else {
                setFeedbackAndRedirect("Incorrect mime type: " . $mime_type_long, "error", $referer);
            }
        }
    } catch (Exception $ex) {
        setFeedbackAndRedirect($ex->getMessage(), "error", $referer);
    }
}

function deleteImage($projectId, $imagePath)
{
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    Project::removeImage($projectId, $imagePath);
    return true;
}
