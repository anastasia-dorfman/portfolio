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
                array_push($posts, new Post($userId, $title, $content, $blogId, [],$postId));
            }

            $stmt->close();

            foreach($posts as $p){
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
    // private static function getTagsByPostId($postId): array
    // {
    //     try {
    //         $con = $GLOBALS['con'];
    //         $sql = "SELECT tag_name FROM post_tags WHERE post_id = $postId";
    //         $result = $con->query($sql);
    //         $numRows = $result->num_rows;
    //         $tags = [];
    //         while ($row = $result->fetch_assoc()) {
    //             array_push($tags, $row['tag_name']);
    //         }
    //         $result->close();

    //         return $tags;
    //     } catch (Exception $ex) {
    //         setFeedbackAndRedirect($ex->getMessage(), "error");
    //     }
    // }

    private static function getTagsByPostId($postId): array
{
    try {
        $tagName = '';
        $con = $GLOBALS['con'];
        $sql = "SELECT tag_name FROM post_tags WHERE post_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $postId);
        $stmt->execute();
        $stmt->bind_result($tagName);

        $tags = [];
        while ($stmt->fetch()) {
            array_push($tags, $tagName);
        }

        $stmt->close();

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
