<?php
function setFeedbackAndRedirect(string $message, string $icon, string $redirectTo = null)
{
	$_SESSION['STATUS'] = $message;
	$_SESSION['STATUS_CODE'] = $icon;

	if ($redirectTo)
		header("Location:$redirectTo");
	else
		header("Refresh:0");
}

// include_once "User.php";
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
				echo '<div class="skills__skill">'.$row['name'].'</div>';
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
		$stmt->bind_param('s', strtolower($username));
		$stmt->execute();
		$stmt->bind_result($userId, $dbPassword, $firstName, $lastName, $userType, $username);
		$stmt->fetch();
		$stmt->close();

		if (password_verify($password, $dbPassword)) {
			$_SESSION["FIRST_NAME"] = $firstName;
			$_SESSION["LAST_NAME"] = $lastName;
			$_SESSION["USER_ID"] = $userId;
			$_SESSION["USERNAME"] = $userId;

			setFeedbackAndRedirect("Thanks for logging in", "success", $referer);
		} else {
			setFeedbackAndRedirect("Incorrect loggin details supplied", "error", "login.php");
		}
	} catch (Exception $ex) {
		setFeedbackAndRedirect($ex->getMessage(), "error", "login.php");
	} finally {
		$con->close();
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