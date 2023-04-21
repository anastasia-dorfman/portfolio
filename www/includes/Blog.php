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

    public function __construct(
        int $userId,
        string $title,
        string $content,
        int $blogId,
        array $tags = null,
        int $postId = null,
    ) {
        $this->userId = $userId;
        $this->title = $title;
        $this->content = $content;
        $this->blogId = $blogId;
        $this->tags = $tags;
        $this->postId = $postId;
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
    #endregion

    #region Public methods
    public static function createPost($userId, $title, $content, $blogId, $tags = []): int
    {
        try {
            $postId = -1;
            $referer = $_SESSION["REFERER"];
            $con = $GLOBALS['con'];
            $sql = "INSERT INTO posts (user_id, title, content, blog_id) VALUES (?,?,?,?)";
            $stmt = $con->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('issi', $userId, $title, $content, $blogId);
                $stmt->bind_result($postId);

                $stmt->execute();
                $stmt->close();

                self::createTags($postId, $tags);
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



    public static function getTweetById(int $tweetId)
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT tweet_text, user_id, original_tweet_id, reply_to_tweet_id, tweet_id, date_created FROM tweets WHERE tweet_id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('i', $tweetId);
            $stmt->execute();
            $result = $stmt->get_result();
            // $stmt->close();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return new Tweet(
                    $row['tweet_text'],
                    $row['user_id'],
                    $row['original_tweet_id'],
                    $row['reply_to_tweet_id'],
                    $row['tweet_id'],
                    $row['date_created']
                );
            } else {
                return null;
            }
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }
}
