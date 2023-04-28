<?php
session_start();

include_once "includes/functions.php";
include_once "includes/Post.php";

$_SESSION["REFERER"] = "create_post.php";

if (!(isset($_SESSION["USERNAME"]))) {
    if ($postId != -1)
        $_SESSION["REFERER"] = "create_post.php?post_id=$postId";
    else
        $_SESSION["REFERER"] = "create_post.php";
    exit;

    header("Location: login.php");
    exit;
}

try {
    // Handle form submission
    if (isset($_POST['createEditPost'])) {
        $userId = $_SESSION["USER_ID"];
        $isEdit = $_POST['isEdit'];
        $postId = $_POST['postId'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $avatar = $_FILES['avatar']['tmp_name'];
        $tags = explode(',', $_POST['tags']);

        $post = null;

        #region Validate form data
        $errors = array();
        if (empty($title)) {
            $errors[] = "Title is required";
        }
        if (empty($content)) {
            $errors[] = "Content is required";
        }
        if (empty($tags)) {
            $errors[] = "At least one tag is required";
        }
        #endregion
        // TODO: Validate image URLs

        // If there are no errors, create/update the post and redirect to the post page
        if (empty($errors)) {
            if ($isEdit) {
                $postId = Post::updatePost($postId, $userId, $title, $content, 1);
                $post = Post::getPostById($postId);
            } else {
                $postId = Post::createPost($userId, $title, $content, 1);
                $post = Post::getPostById($postId);
            }

            Post::updateTags($tags, $postId);
            uploadAvatar($postId, $isEdit);
            if ($isEdit)
                Post::deleteIamages($postId);
            uploadImages($postId);

            setFeedbackAndRedirect("Post saved successfully", "success", "post.php?post_id=" . $post->getPostId());
        } else {
            $msg = '';
            foreach ($errors as $e) {
                $msg .= $e . '\n';
            }
            setFeedbackAndRedirect($e, "error", "create_post.php");
        }
    }
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", "create_post.php");
}

function uploadAvatar($postId, $isEdit)
{
    try {
        if (!empty($_FILES['avatar']['tmp_name'])) {
            $avatar = $_FILES['avatar']['tmp_name'];
            $avatar_info = new finfo(FILEINFO_MIME);

            $mime_type_long = $avatar_info->buffer(file_get_contents($avatar));
            $intpos = strpos($mime_type_long, ";");
            $mime_type = substr($mime_type_long, 0, $intpos);

            if (
                $mime_type == 'image/png' || $mime_type == 'image/jpeg' || $mime_type == 'image/jpg' ||
                $mime_type == 'image/gif' || $mime_type == 'image/bmp' || $mime_type == 'image/pjpg' || $mime_type == 'image/x-png'
            ) {
                doFileCheck($avatar, $postId, $isEdit);
            } else {
                setFeedbackAndRedirect("Not so fast, incorrect mime type ... $mime_type_long", "error");
            }
        }
    } catch (Exception $ex) {
        setFeedbackAndRedirect($ex->getMessage(), "error");
    }
}

function uploadImages($postId)
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

                if (
                    $mime_type == 'image/png' || $mime_type == 'image/jpeg' || $mime_type == 'image/jpg' ||
                    $mime_type == 'image/gif' || $mime_type == 'image/bmp' || $mime_type == 'image/pjpg' || $mime_type == 'image/x-png'
                ) {
                    doFileCheck($file, $postId, false, $i);
                } else {
                    setFeedbackAndRedirect("Not so fast, incorrect mime type ... $mime_type_long", "error");
                }
            }
        }
    } catch (Exception $ex) {
        setFeedbackAndRedirect($ex->getMessage(), "error");
    }
}
function doFileCheck($file, $postId, $isEdit, $index = null)
{
    if (is_null($index)) {
        $pathinfo = pathinfo($_FILES['avatar']['name']);
        $basename = "post" . $postId . "_avatar." . $pathinfo['extension'];
    } else {
        $pathinfo = pathinfo($_FILES['image']['name'][$index]);
        $basename = "post" . $postId . "_image" . ($index + 1) . "." . $pathinfo['extension'];
    }

    $imginfo_array = getimagesize($file);

    if ($imginfo_array !== false) {
        $uploaddir = './assets/images/';
        $uploadfile = $uploaddir . $basename;

        if (file_exists($uploadfile)) {
            unlink($uploadfile);
        }

        if (move_uploaded_file($file, $uploadfile)) {
            if (!Post::updateImage($uploadfile, $basename, $postId, $isEdit, $index)) {
                setFeedbackAndRedirect("Post created, but there was an Error uploading image(s)", "error");
            }
        } else {
            setFeedbackAndRedirect("Invalid File, malicious attack perhaps?", "error");
        }
    }
}
