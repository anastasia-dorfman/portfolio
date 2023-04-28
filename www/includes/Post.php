<?php
include "includes/dbConnection.php";
include_once "includes/functions.php";

/**
 * Post class
 * This class will hold all post related functions
 */
class Post
{
    private $userId;
    private $title;
    private $content;
    private $blogId;
    private $created_at;
    private $tags = [];
    private $postId;
    private $images = [];
    private $avatar = '';

    public function __construct(
        int $userId,
        string $title,
        string $content,
        int $blogId,
        array $tags = null,
        int $postId = null,
        array $images = null,
        string $avatar = null
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->blogId = $blogId;
        $this->tags = $tags;
        $this->postId = $postId;
        $this->images = $images;
        $this->avatar = $avatar;
    }

    #region Getters/Setters

    public function getUserId(): int
    {
        return $this->userId;
    }
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
    public function setContent(int $content): void
    {
        $this->content = $content;
    }

    public function getBlogId(): int
    {
        return $this->blogId;
    }
    public function setBlogId(int $blogId): void
    {
        $this->blogId = $blogId;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }
    public function setPostId(int $postId): void
    {
        $this->postId = $postId;
    }

    public function getImages(): array
    {
        return $this->images;
    }
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }
    public function setAvatar(string $avatar): void
    {
        $this->avatar = $avatar;
    }

    #endregion

    #region Public methods
    public static function getPostById(int $postId)
    {
        try {
            $tags = self::getTagsByPostId($postId);
            $images = self::getImagesByPostId($postId);
            $avatar = self::getAvatarByPostId($postId);

            $con = $GLOBALS['con'];
            $sql = "SELECT title, content, created_at, blog_id, user_id FROM posts WHERE post_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('i', $postId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return new Post(
                    $row['user_id'],
                    $row['title'],
                    $row['content'],
                    $row['blog_id'],
                    $tags,
                    $postId,
                    $images,
                    $avatar
                );
            } else {
                return null;
            }
            $stmt->close();
            $result->close();
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }
    public static function createPost($userId, $title, $content, $blogId): int
    {
        try {
            $postId = -1;
            $referer = $_SESSION["REFERER"];
            $con = $GLOBALS['con'];
            $sql = "INSERT INTO posts (user_id, title, content, blog_id) VALUES (?,?,?,?)";
            $stmt = $con->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('issi', $userId, $title, $content, $blogId);
                $stmt->execute();
                $postId = $stmt->insert_id;
                $stmt->close();
            } else {
                setFeedbackAndRedirect("An error occured", "error");
            }

            return $postId;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function updatePost($postId, $userId, $title, $content, $blogId)
    {
        try {
            $referer = $_SESSION["REFERER"];
            $con = $GLOBALS['con'];
            $sql = "UPDATE posts SET user_id = ?, title = ?, content = ?, blog_id = ? WHERE post_id = ?";
            $stmt = $con->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('issii', $userId, $title, $content, $blogId, $postId);
                $stmt->execute();
                $stmt->close();

                setFeedbackAndRedirect("The post was updated", "success", $referer);
            } else {
                setFeedbackAndRedirect("An error occured", "error");
            }

            return $postId;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function getPosts(int $blogId = null): array
    {
        try {
            $title = '';
            $content = '';
            $dateCreated = '';
            $userId = -1;
            $postId = -1;
            $blogId = $blogId == null ? 1 : $blogId;

            $con = $GLOBALS['con'];
            $sql = "SELECT post_id, title, content, created_at, user_id FROM posts WHERE blog_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('i', $blogId);
            $stmt->execute();
            $stmt->bind_result($postId, $title, $content, $dateCreated, $userId);

            $posts = [];

            while ($stmt->fetch()) {
                array_push($posts, new Post($userId, $title, $content, $blogId, [], $postId));
            }

            $stmt->close();

            foreach ($posts as $p) {
                $postId = $p->getPostId();
                $tags = [];
                $tags = self::getTagsByPostId($postId);
                $images = [];
                $images = self::getImagesByPostId($postId);
                $avatar = '';
                $avatar = self::getAvatarByPostId($postId);
                $p->setTags($tags);
                $p->setImages($images);
                $p->setAvatar($avatar);
            }

            return $posts;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function updateImage($imageLink, $fileName, $postId, $isUpdate, $index = null)
    {
        try {
            $con = $GLOBALS['con'];

            if (is_null($index)) {
                if (!$isUpdate)
                    $sql = "INSERT INTO images (type, link, post_id, name) VALUES('avatar', '$imageLink', $postId, '$fileName')";
                $con->query($sql);
            } else {
                $sql2 = "INSERT INTO images (type, link, post_id, name) VALUES('image', '$imageLink', $postId, '$fileName')";
                $con->query($sql2);
            }

            return true;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function updateTags($tags, $postId)
    {
        try {
            $con = $GLOBALS['con'];

            $dbTags = [];

            $sql = "SELECT name FROM tags";
            $result = $con->query($sql);

            while ($row = $result->fetch_assoc()) {
                array_push($dbTags, $row['name']);
            }

            $sql2 = "DELETE FROM post_tags WHERE post_id = $postId";
            $con->query($sql2);

            foreach ($tags as $t) {
                $sql3 = "INSERT INTO tags (name) VALUES ('$t')";
                if (!in_array($t, $dbTags)) {
                    $con->query($sql3);
                }
                $sql4 = "INSERT INTO post_tags (post_id, tag_name) VALUES ($postId, '$t')";
                $con->query($sql4);
            }

            return true;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function countImage($postId)
    {
        try {
            $numImages = -1;
            $con = $GLOBALS['con'];

            $sql = "SELECT image_id FROM images WHERE post_id = $postId";
            $result = $con->query($sql);
            $numImages = $result->num_rows;
            return $numImages;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function deleteIamages($postId)
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "DELETE FROM images WHERE post_id = $postId AND type = 'image'";
            $con->query($sql);
            return true;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }


    #region Private Methods
    private static function getTagsByPostId($postId): array
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT tag_name FROM post_tags WHERE post_id = $postId";
            $result = $con->query($sql);
            $numRows = $result->num_rows;
            $tags = [];
            while ($row = $result->fetch_assoc()) {
                array_push($tags, $row['tag_name']);
            }
            $result->close();

            return $tags;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    private static function getAvatarByPostId($postId): string
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT link FROM images WHERE post_id = $postId AND type = 'avatar'";
            $result = $con->query($sql);
            $numRows = $result->num_rows;
            $avatar = '';

            if ($numRows == 1) {
                $row = $result->fetch_assoc();
                $avatar = $row['link'];
            }

            $result->close();

            return $avatar;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    private static function getImagesByPostId($postId): array
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT link FROM images WHERE post_id = $postId AND type = 'image'";
            $result = $con->query($sql);
            // $numRows = $result->num_rows;
            $images = [];
            while ($row = $result->fetch_assoc()) {
                array_push($images, $row['link']);
            }
            $result->close();

            return $images;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }
    #endregion
}
