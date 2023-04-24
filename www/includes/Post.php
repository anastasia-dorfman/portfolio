<?php
include "includes/dbConnection.php";
include "includes/functions.php";

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

                // self::createTags($postId, $tags);
                // self::createPostImages($postId, $images);
            } else {
                setFeedbackAndRedirect("An error occured", "error");
            }

            if ($postId > 0)
                setFeedbackAndRedirect("The post is created", "success", $referer);

            $con->close();
            return $postId;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function getPosts(int $blogId)
    {
        try {
            $title = '';
            $content = '';
            $dateCreated = '';
            $userId = -1;

            $con = $GLOBALS['con'];
            $sql = "SELECT post_id, title, content, created_at, blog_id, user_id FROM posts WHERE blog_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('i', $blogId);
            $postId = $stmt->insert_id;
            $stmt->bind_result($postId, $title, $content, $dateCreated, $blogId, $userId);
            $stmt->execute();

            $posts = [];

            if ($stmt->num_rows > 0) {
                while ($stmt->fetch()) {
                    $tags = [];
                    $tags = self::getTagsByPostId($postId);
                    $images = [];
                    $images = self::getImagesByPostId($postId);
                    $posts =  new Post($userId, $title, $content, $blogId, $tags, $postId, $images);
                }
            }

            $stmt->close();
            return $posts;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function displayPosts(array $posts)
    {
        try {
            if (!empty($posts)) {
                echo '<div class="projects__content">';

                foreach ($posts as $p) {

                    $tags = $p->getTags();
                    // $images = $p->getImages();

                    echo '<div class="projects__row">';
                    echo '<div class="projects__row-img-cont">';

                    // foreach ($images as $i) {
                    //     echo "<img src=".$i." alt='Post Image' class='projects__row-img' loading='lazy' />";
                    // }

                    echo "<img src=" . $p->getAvatar() . " alt='Post Image' class='projects__row-img' loading='lazy' />";
                    echo '</div>';
                    echo '<div class="projects__row-content">';
                    echo '<h3 class="projects__row-content-title">' . $p->getTitle() . '</h3>';
                    echo '<p class="projects__row-content-desc">' . substr("{$p->getContent()}", 0, 100) . '</p>';
                    echo '<a href="./post.php?id=".$p->getPostId()." class="btn btn--med btn--theme dynamicBgClr" target="_blank">Read more</a>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo 'There are no posts yet';
            }
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
                $tags = $row['tag_name'];
            }
            $result->close();
            $con->close();

            return $tags;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    private static function getAvatarByPostId($postId): string
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT link FROM images WHERE post_id = $postId AND type = `avatar`";
            $result = $con->query($sql);
            $numRows = $result->num_rows;
            $avatar = '';
            
            if ($numRows == 1) {
                $row = $result->fetch_assoc();
                $avatar = $row['link'];
            }

            $result->close();
            $con->close();

            return $avatar;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    private static function getImagesByPostId($postId): array
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT link FROM images WHERE post_id = $postId";
            $result = $con->query($sql);
            // $numRows = $result->num_rows;
            $images = [];
            while ($row = $result->fetch_assoc()) {
                $images = $row['link'];
            }
            $result->close();
            $con->close();

            return $images;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    private static function createTags($postId, $tags)
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "INSERT INTO post_tags (post_id, tag_name) VALUES (?,?)";
            $sql2 = "INSERT INTO tags (name, is_post_tag) VALUES (?,?)";
            $stmt = $con->prepare($sql);
            $stmt2 = $con->prepare($sql2);

            foreach ($tags as $t) {

                if ($stmt) {
                    $stmt->bind_param('is', $postId, $t);
                    $stmt->execute();

                    if ($stmt2) {
                        $stmt->bind_param('si', $postId, 1);
                        $stmt->execute();
                    } else {
                        setFeedbackAndRedirect("An error occured", "error");
                    }
                } else {
                    setFeedbackAndRedirect("An error occured", "error");
                }
            }

            $stmt->close();
            $stmt2->close();
            $con->close();
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }
    private static function createPostImage($postId, $image, $imageType)
    {
        try {
            $names = []; // TODO extract names from links
            // $i = '';
            $con = $GLOBALS['con'];
            $sql = "INSERT INTO images (post_id, link, type) VALUES ($postId, $image, $imageType)";

            // foreach ($images as $i) {
            //     $result = $con->query($sql);
                // $imageId = $con->insert_id;
            // }

            $result = $con->query($sql);

            $result->close();
            $con->close();
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }
    #endregion
}
