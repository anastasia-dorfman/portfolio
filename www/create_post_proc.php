<?php
session_start();

include_once "includes/functions.php";

$postId = $_GET['post_id'] ?? -1;
$_SESSION["REFERER"] = "create_post.php" . ($postId !== -1 ? "?post_id=$postId" : "");
$referer = $_SESSION["REFERER"];

if (!(isset($_SESSION["USERNAME"]))) {
    header("Location: login.php");
    exit;
}

include_once "includes/Post.php";
include_once "includes/Project.php";

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['removeImage'])) {
        $postId = $_POST['postId'];
        $link = $_POST['link'];
        deleteImage($postId, $link);
        header("Location:create_post.php?post_id=$postId");
        exit;
    }

    if (isset($_POST['createEditPost'])) {
        $userId = $_SESSION["USER_ID"];
        $isEdit = $_POST['isEdit'];
        $postId = $_POST['postId'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $tags = explode(',', $_POST['tags']);

        $cleanTags = [];
        foreach ($tags as $tag) {
            $cleanTag = str_replace('  ', ' ', trim($tag));
            if (empty($cleanTag)) {
                continue;
            }
            $cleanTags[] = $cleanTag;
        }
        // $avatar = $_POST['avatar'];

        $post = $postId == -1 ? null : Post::getPostById($postId);

        // $avatar = $post != null ? $post->getAvatar() : $_POST['avatar'];

        $errors = validateFormData($title, $content);

        if (!empty($errors)) {
            setFeedbackAndRedirect(implode("\n", $errors), "error", $referer);
            return;
        }

        $lastSavedImageIndex = 0;

        if ($isEdit) {
            $postId = Post::updatePost($postId, $userId, $title, $content, 1);
            $lastSavedImageIndex = Post::getLastImageIndex($postId);
        } else {
            $postId = Post::createPost($userId, $title, $content, 1);
        }

        $tools = Project::getAllTools();
        Post::updateTags($cleanTags, $postId, $tools);
        uploadFile($postId, 'avatar', 'avatar');
        uploadFile($postId, 'image', 'image', $lastSavedImageIndex);

        $post = Post::getPostById($postId);

        setFeedbackAndRedirect("Post saved successfully", "success", "post.php?post_id=" . $post->getPostId());
    }
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", $referer);
}

function uploadFile($postId, $fileType, $prefix, $lastSavedImageIndex = null,  $fileFieldName = null)
{
    try {
        $fileFieldName = $fileFieldName ?? $fileType;
        $allowedFileTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp', 'image/pjpg', 'image/x-png'];

        if (empty($_FILES[$fileFieldName]['name']) || empty($_FILES[$fileFieldName]['name'][0])) {
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
                $basenameNoExtension = "post" . $postId . "_" . $prefix . $basenameIndex ?? '';
                $basename = $basenameNoExtension . "." . $extension;

                $imginfo_array = getimagesize($tempFile);

                if ($imginfo_array !== false) {
                    $uploaddir = './assets/images/';
                    $uploadfile = $uploaddir . $basename;

                    foreach (glob($uploaddir . $basenameNoExtension . '.*') as $filename) {
                        unlink($filename);
                    }

                    if (move_uploaded_file($tempFile, $uploadfile)) {
                        if (!Post::updateImage($uploadfile, $basenameNoExtension, $postId, $basenameIndex)) {
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

function deleteImage($postId, $imagePath)
{
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
    Post::removeImage($postId, $imagePath);
    return true;
}

function validateFormData($title, $content)
{
    $errors = [];
    if (empty($title)) {
        $errors[] = "Title is required";
    }
    if (empty($content)) {
        $errors[] = "Content is required";
    }
    if (empty($_POST['tags'])) {
        $errors[] = "At least one tag is required";
    }
    // if (empty($avatar)) {
    //     $errors[] = "Avatar is required";
    // }
    return $errors;
}
