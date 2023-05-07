<?php
session_start();

include_once "includes/functions.php";

$projectId = $_GET['project_id'] ?? -1;

if (!(isset($_SESSION["USERNAME"]))) {
    $_SESSION["REFERER"] = "delete_project_proc.php?project_id=$projectId";
    header("Location: login.php");
    exit;
}

include_once "includes/Project.php";

try {
    $project = $projectId == -1 ? null : Project::getProjectById($projectId);

    if ($project != null) {
        Project::deleteProject($project);
    }

    setFeedbackAndRedirect("Project was deleted", "success", "index.php#projects");
} catch (Exception $ex) {
    setFeedbackAndRedirect($ex->getMessage(), "error", "project.php?project_id=$projectId");
}
