<?php

include_once "includes/dbConnection.php";

function setFeedbackAndRedirect(string $message, string $icon, string $redirectTo = null)
{
	$_SESSION['STATUS'] = $message;
	$_SESSION['STATUS_CODE'] = $icon;

	if ($redirectTo)
		header("Location:$redirectTo");
	else
		header("Refresh:0");
}

/**
 * Getting scalar value from SELECT query
 *
 * @param [type] $con connection
 * @param [string] $tableName Name of the table
 * @param [string] $columnName Name of the column to count
 * @param [string] $filterColumn Name of the column that is used as filter
 * @param [type] $filterValue  Value of the filter column
 * @return int
 */
function getSkills()
{
	try {
		include_once "includes/dbConnection.php";
		$con = $GLOBALS['con'];
		$sql = "SELECT * FROM skills";
		$result = $con->query($sql);

		if ($result->num_rows > 0) {
			echo '<div class="skills">';
			while ($row = $result->fetch_assoc()) {
				echo '<div class="skills__skill">' . $row['name'] . '</div>';
			}
			echo '</div>';
		}
	} catch (Exception $ex) {
		//throw $th;
	}
	include_once "includes/dbConnection.php";
	$con = $GLOBALS['con'];
	$sql = "SELECT * FROM skills";
	$result = $con->query($sql);
}

function login($username, $password)
{
	$referer = isset($_SESSION["REFERER"]) ? $_SESSION["REFERER"] : "index.php";

	validateLogin($username, $password);

	try {
		$con = $GLOBALS['con'];

		$userId = 0;
		$dbPassword = '';
		$firstName = '';
		$lastName = '';
		$userType = '';

		$sql = "SELECT user_id, password, f_name, l_name, user_type, u_name FROM users where LOWER(u_name) = ?";
		$stmt = $con->prepare($sql);
		$username = strtolower($username);
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->bind_result($userId, $dbPassword, $firstName, $lastName, $userType, $username);

		if ($stmt->fetch()) {
			$_SESSION["FIRST_NAME"] = $firstName;

			if (password_verify($password, $dbPassword)) {
				$_SESSION["USERNAME"] = $username;
				$_SESSION["FIRST_NAME"] = $firstName;
				$_SESSION["LAST_NAME"] = $lastName;
				$_SESSION["USER_ID"] = $userId;
				$_SESSION["USER_TYPE"] = $userType;

				setFeedbackAndRedirect("Thanks for logging in", "success", $referer);
			} else {
				setFeedbackAndRedirect("Incorrect loggin details supplied", "error", "login.php");
			}
		} else {
			setFeedbackAndRedirect("Incorrect loggin details supplied", "error", "login.php");
		}

		$stmt->close();
		$con->close();
	} catch (Exception $ex) {
		setFeedbackAndRedirect($ex->getMessage(), "error", "login.php");
	}
}

function validateLogin($username, $password)
{
	if (strlen($username) > 50 || !is_string($username)) {
		setFeedbackAndRedirect("Invalid username", "error", "login.php");
		exit;
	} elseif (strlen($password) > 250 || !is_string($password)) {
		setFeedbackAndRedirect("Invalid password", "error", "login.php");
		exit;
	}
}

function createTags($postId, $tags)
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

function createPostImage($postId, $image, $imageType)
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

function getUserType($username)
{
	try {
		$names = []; // TODO extract names from links
		$con = $GLOBALS['con'];
		$sql = "SELECT user_type FROM users WHERE u_name = $username";

		$result = $con->query($sql);
		$row = $result->fetch_assoc();

		$result->close();
		$con->close();

		return $row['user_type'];
	} catch (Exception $ex) {
		setFeedbackAndRedirect($ex->getMessage(), "error");
	}
}
