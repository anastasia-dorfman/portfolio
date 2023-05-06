<?php
include "includes/dbConnection.php";
include_once "includes/functions.php";

/**
 * Project class
 */
class Project
{
    private $name;
    private $description;
    private $overview;
    private $dateCreated;
    private $codeLink;
    private $avatar;
    private $tags = [];
    private $images = [];
    private $projectId;

    public function __construct(
        string $name,
        string $description,
        string $overview,
        $dateCreated,
        string $codeLink,
        string $avatar,
        array $tags = null,
        array $images = null,
        int $projectId = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->overview = $overview;
        $this->dateCreated = $dateCreated;
        $this->codeLink = $codeLink;
        $this->avatar = $avatar;
        $this->tags = $tags;
        $this->images = $images;
        $this->projectId = $projectId;
    }

    #region Getters/Setters

    public function getName(): string
    {
        return $this->name;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(int $description): void
    {
        $this->description = $description;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }
    public function setOverview(int $overview): void
    {
        $this->overview = $overview;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    public function getCodeLink(): string
    {
        return $this->codeLink;
    }
    public function setCodeLink(int $codeLink): void
    {
        $this->codeLink = $codeLink;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }
    public function setAvatar(int $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getProjectId(): int
    {
        return $this->projectId;
    }
    public function setProjectId(int $projectId): void
    {
        $this->projectId = $projectId;
    }

    public function getTags(): array
    {
        return $this->tags;
    }
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function getImages(): array
    {
        return $this->images;
    }
    public function setImages(array $images): void
    {
        $this->images = $images;
    }
    #endregion

    #region Public methods
    public static function getProjects(): array
    {
        try {
            $name = '';
            $description = '';
            $overview = '';
            $codeLink = '';
            $dateCreated = '';
            $projectId = -1;

            $con = $GLOBALS['con'];
            $sql = "SELECT id, name, description, overview, code_link, created_at FROM projects";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $stmt->bind_result($projectId, $name, $description, $overview, $codeLink, $dateCreated);

            $projects = [];

            while ($stmt->fetch()) {
                array_push($projects, new Project($name, $description, $overview, $dateCreated, $codeLink, '', [], [], $projectId));
            }

            $stmt->close();

            foreach ($projects as $p) {
                $projectId = $p->getProjectId();
                $avatar = '';
                $avatar = self::getAvatarByProjectId($projectId);
                $tags = [];
                $tags = self::getTagsByProjectId($projectId);
                $images = [];
                $images = self::getImagesByProjectId($projectId);
                $p->setTags($tags);
                $p->setImages($images);
            }

            return $projects;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function getProjectById(int $projectId)
    {
        try {
            $tags = self::getTagsByProjectId($projectId);
            $avatar = self::getAvatarByProjectId($projectId);
            $images = self::getImagesByProjectId($projectId);

            $con = $GLOBALS['con'];
            $sql = "SELECT name, description, overview, code_link, created_at FROM projects WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param('i', $projectId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return new Project(
                    $row['name'],
                    $row['description'],
                    $row['overview'],
                    $row['created_at'],
                    $row['code_link'],
                    $avatar,
                    $tags,
                    $images,
                    $projectId
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
    public static function createProject($name, $description, $overview, $codeLink, $dateCreated): int
    {
        try {
            $projectId = -1;
            $con = $GLOBALS['con'];
            $sql = "INSERT INTO projects (name, description, overview, code_link, created_at) VALUES (?,?,?,?,?)";
            $stmt = $con->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('sssss', $name, $description, $overview, $codeLink, $dateCreated);
                $stmt->execute();
                $projectId = $stmt->insert_id;
                $stmt->close();
            } else {
                setFeedbackAndRedirect("An error occured", "error");
            }

            return $projectId;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function updateProject($projectId, $name, $description, $overview, $codeLink, $dateCreated = null)
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "UPDATE projects SET name = ?, description = ?, overview = ?, code_link = ?, created_at = ? WHERE id = ?";
            $stmt = $con->prepare($sql);

            if ($stmt) {
                $stmt->bind_param('sssssi', $name, $description, $overview, $codeLink, $dateCreated, $projectId);
                $stmt->execute();
                $stmt->close();
            } else {
                setFeedbackAndRedirect("An error occured", "error");
            }

            return $projectId;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function deletePost($postId, $post): int
    {
        try {
            $con = $GLOBALS['con'];
            $sql1 = "DELETE FROM post_tags WHERE post_id = $postId";
            $con->query($sql1);

            $sql2 = "DELETE FROM images WHERE post_id = $postId";
            $con->query($sql2);

            $images = [];

            if (isset($post->getAvatar))
                array_push($images, $post->getAvatar);
            if (isset($post->getImages))
                array_push($images, $post->getImages);

            foreach ($images as $i) {
                unlink($i);
            }

            $sql3 = "DELETE FROM posts WHERE post_id = $postId";
            $con->query($sql3);

            return true;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function removeImage($projectId, $imageLink)
    {
        try {
            $con = $GLOBALS['con'];

            $sql = "DELETE FROM images WHERE link = '$imageLink' AND project_id = $projectId";
            $con->query($sql);

            return true;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function updateImage($imageLink, $fileName, $projectId, $index = null)
    {
        try {
            $type = is_null($index) ? 'avatar' : 'image';

            $con = $GLOBALS['con'];
            $sql = "INSERT INTO images (type, link, project_id, name) VALUES('$type', '$imageLink', $projectId, '$fileName')";
            $con->query($sql);

            return true;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function updateTags($tags, $projectId)
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT name, type FROM skills";
            $result = $con->query($sql);

            $dbTags = [];
            while ($row = $result->fetch_assoc()) {
                array_push($dbTags, $row['name']);
            }

            $sql2 = "DELETE FROM project_skills WHERE project_id = $projectId";
            $con->query($sql2);

            foreach ($tags as $t) {
                $sql4 = "INSERT INTO project_skills (project_id, skill_name) VALUES ($projectId, '$t')";
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
            $numImages = 0;
            $con = $GLOBALS['con'];

            $sql = "SELECT image_id FROM images WHERE post_id = $postId";
            $result = $con->query($sql);
            $numImages = $result->num_rows;
            return $numImages;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function getLastImageIndex($projectId)
    {
        try {
            $imageIndex = 0;
            $con = $GLOBALS['con'];

            $sql = "SELECT name FROM images WHERE project_id = $projectId AND type = 'image' ORDER BY name DESC LIMIT 1";
            $result = $con->query($sql);
            $numImages = $result->num_rows;

            if ($numImages > 0) {
                $row = $result->fetch_assoc();
                $name = $row['name'];
                // $pattern = "/image(\d+)$/i";
                $pattern = "/image(\d+)/i";
                preg_match($pattern, $name, $matches);
                $imageIndex = $matches[1];
            }

            $result->close();

            return $imageIndex;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function getFirstImageIndex($projectId)
    {
        try {
            $imageIndex = 0;
            $name = self::getFirstImage($projectId);

            if ($name !== null) {
                $pattern = "/image(\d+)$/i";
                preg_match($pattern, $name, $matches);
                $imageIndex = $matches[1];
            }

            return $imageIndex;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function getAvatarByProjectId($projectId)
    {
        try {
            $avatar = '';
            $con = $GLOBALS['con'];

            $sql = "SELECT link FROM images WHERE project_id = $projectId AND type = 'avatar'";
            $result = $con->query($sql);
            $numRows = $result->num_rows;

            if ($numRows === 1) {
                $row = $result->fetch_assoc();
                $avatar = $row['link'];
            }

            $result->close();

            return $avatar;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    public static function getFirstImage($projectId)
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT link FROM images WHERE project_id = $projectId AND type = 'image' ORDER BY name ASC LIMIT 1";
            $result = $con->query($sql);
            $numImages = $result->num_rows;
            $name = '';

            if ($numImages > 0) {
                $row = $result->fetch_assoc();
                $name = $row['link'];
            }

            $result->close();

            return $name;
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

    public static function getAllTools()
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT * FROM skills";
            $result = $con->query($sql);
            $tools = [];

            while ($row = $result->fetch_assoc())
                array_push($tools, $row['name']);

            $result->close();

            return $tools;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    #region Private Methods
    private static function getTagsByProjectId($projectId): array
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT skill_name FROM project_skills WHERE project_id = $projectId";
            $result = $con->query($sql);
            $tags = [];
            while ($row = $result->fetch_assoc()) {
                array_push($tags, $row['skill_name']);
            }
            $result->close();

            return $tags;
        } catch (Exception $ex) {
            setFeedbackAndRedirect($ex->getMessage(), "error");
        }
    }

    private static function getImagesByProjectId($projectId): array
    {
        try {
            $con = $GLOBALS['con'];
            $sql = "SELECT link FROM images WHERE project_id = $projectId AND type = 'image'";
            $result = $con->query($sql);
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
