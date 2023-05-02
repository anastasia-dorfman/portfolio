<?php
session_start();

include_once "includes/functions.php";

$_SESSION["REFERER"] = "create_post.php";

if (!(isset($_SESSION["USERNAME"]))) {
    $postId = $_GET['post_id'] ?? -1;
    $_SESSION["REFERER"] = "create_post.php" . ($postId !== -1 ? "?post_id=$postId" : "");
    header("Location: login.php");
    exit;
}

include_once "includes/Post.php";

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

        $errors = validateFormData($title, $content, $tags);

        if (!empty($errors)) {
            setFeedbackAndRedirect(implode("\n", $errors), "error", "create_post.php");
            return;
        }

        $lastSavedImageIndex = 0;

        if ($isEdit) {
            $postId = Post::updatePost($postId, $userId, $title, $content, 1);
            $lastSavedImageIndex = Post::getLastImageIndex($postId);
        } else {
            $postId = Post::createPost($userId, $title, $content, 1);
        }

        Post::updateTags($tags, $postId);
        uploadFile($postId, 'avatar', 'avatar');
        uploadFile($postId, 'image', 'image', $lastSavedImageIndex);

        $post = Post::getPostById($postId);

        setFeedbackAndRedirect("Post saved successfully", "success", "post.php?post_id=" . $post->getPostId());
    }
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", "create_post.php");
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
            $file = $lastSavedImageIndex === null ? $_FILES[$fileFieldName]['tmp_name'] : $_FILES[$fileFieldName]['tmp_name'][$i];
            $file_info = new finfo(FILEINFO_MIME);

            $mime_type_long = $file_info->buffer(file_get_contents($file));
            $intpos = strpos($mime_type_long, ";");
            $mime_type = substr($mime_type_long, 0, $intpos);

            if (in_array($mime_type, $allowedFileTypes)) {
                $pathinfo = pathinfo($_FILES[$fileFieldName]['name'][$i]);
                $basenameIndex = $fileType == 'avatar' ? null : $i + $lastSavedImageIndex + 1;
                $basename = "post" . $postId . "_" . $prefix . $basenameIndex ?? '' . "." . $pathinfo['extension'];

                $imginfo_array = getimagesize($file);

                if ($imginfo_array !== false) {
                    $uploaddir = './assets/images/';
                    $uploadfile = $uploaddir . $basename;

                    if (file_exists($uploadfile)) {
                        unlink($uploadfile);
                    }

                    if (move_uploaded_file($file, $uploadfile)) {
                        if (!Post::updateImage($uploadfile, $basename, $postId, $basenameIndex)) {
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
        Post::removeImage($postId, $imagePath);
        return true;
    } else {
        return false;
    }
}

function validateFormData($title, $content, $tags)
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
    return $errors;
}
