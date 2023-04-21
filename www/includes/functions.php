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