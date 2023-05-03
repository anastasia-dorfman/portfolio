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
// use App\Post;

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
        $avatar = $_FILES['avatar']['tmp_name'];
        $tags = explode(',', $_POST['tags']);

        $errors = validateFormData($title, $content, $tags);

        if (count($errors) > 0) {
            $msg = implode("\n", $errors);
            // throw new Exception(implode("\n", $errors));
            setFeedbackAndRedirect($msg, "error", "create_post.php");
        }

        $post = null;

        if ($isEdit) {
            $postId = Post::updatePost($postId, $userId, $title, $content, 1);
            $lastSavedImageIndex = Post::getLastImageIndex($postId);
        } else {
            $postId = Post::createPost($userId, $title, $content, 1);
        }

        $post = Post::getPostById($postId);

        Post::updateTags($tags, $postId);
        uploadAvatar($postId);
        uploadImages($postId, $lastSavedImageIndex);

        setFeedbackAndRedirect("Post saved successfully", "success", "post.php?post_id=" . $post->getPostId());
    }
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", "create_post.php");
}

function uploadAvatar($postId)
{
    try {
        if (!empty($_FILES['avatar']['tmp_name'])) {
            $avatar = $_FILES['avatar']['tmp_name'];
            $avatar_info = new finfo(FILEINFO_MIME);

            $mime_type_long = $avatar_info->buffer(file_get_contents($avatar));
            $intpos = strpos($mime_type_long, ";");
            $mime_type = substr($mime_type_long, 0, $intpos);

            $allowed_mime_types = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp', 'image/pjpg', 'image/x-png');

            if (in_array($mime_type, $allowed_mime_types)) {
                doFileCheck($avatar, $postId);
            } else {
                setFeedbackAndRedirect("Incorrect mime type: " . $mime_type_long, "error");
            }
        }
    } catch (Exception $ex) {
        setFeedbackAndRedirect($ex->getMessage(), "error");
    }
}

function uploadImages($postId, $lastSavedImageIndex = null)
{
    try {
        // Check if at least one file was uploaded
        if (!empty($_FILES['image']['tmp_name'][0])) {
            $total = count($_FILES['image']['name']);

            // Loop through each file and do the checks
            for ($i = 0; $i < $total; $i++) {
                $file = $_FILES['image']['tmp_name'][$i];
                $file_info = new finfo(FILEINFO_MIME);
                $mime_type_long = $file_info->buffer(file_get_contents($file));
                $intpos = strpos($mime_type_long, ";");
                $mime_type = substr($mime_type_long, 0, $intpos);

                $allowed_mime_types = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp', 'image/pjpg', 'image/x-png');

                if (in_array($mime_type, $allowed_mime_types)) {
                    doFileCheck($file, $postId, $i, $lastSavedImageIndex);
                } else {
                    setFeedbackAndRedirect("Incorrect mime type: " . $mime_type_long, "error");
                }
            }
        }
    } catch (Exception $ex) {
        setFeedbackAndRedirect($ex->getMessage(), "error");
    }
}
function doFileCheck($file, $postId, $index = null, $lastSavedImageIndex = null)
{
    if (is_null($index)) {
        $pathinfo = pathinfo($_FILES['avatar']['name']);
        $basename = "post" . $postId . "_avatar." . $pathinfo['extension'];
    } else {
        $pathinfo = pathinfo($_FILES['image']['name'][$index]);
        $basenameIndex = $index + 1 + $lastSavedImageIndex;
        $basename = "post" . $postId . "_image" . $basenameIndex . "." . $pathinfo['extension'];
    }

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
    if (empty($tags)) {
        $errors[] = "At least one tag is required";
    }
    return $errors;
}
