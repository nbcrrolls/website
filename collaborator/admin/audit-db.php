<?php
        require_once("../content/common.php");
        require_once("../content/accountInfo.php");
        require_once("../content/dataArrays.php");
        require_once("../content/functions.php");
        require_once("../content/databaseFunctions.php");

	#checkLogin();

	#####
	## Edmond Negado
	## This php page cleans out the collaborator database.
	#####

	## global messages and error messages strings.
	$messages = "";
	$emessages = "";
	
	function saveApplicationByID () {}
	
	function removeApplicationByID ($id) {
		
		global $emessages, $messages;
		
		$error_codes = array();
		## return false if id is not set or invalid.
		if (empty($id) || !isset($id)) return false;
		
		## open the database.
		$dbhandle = openDB();

		#####################################################################################
		$del_query = "DELETE from applications WHERE id='$id'";
		## execute the row deletion based on ID.
		$result = mysql_query($del_query, $dbhandle);
		
		## check if it was successful (should return true if successful)
		if (!$result) {
			## not successful, print error message, and print mysql_error
			$errno = mysql_errno($dbhandle);
			if ( ! array_key_exists($errno, $error_codes) ) {
				array_push($error_codes, $errno);
			}
		} else {
			## print to messages of successful 'applications' table deletion.
			if (mysql_affected_rows($dbhandle)) {
				$messages .= "Applications table - deletion success.<br/>";
			} else {
				$messages .= "Applications table - ID does not exist.<br/>";
			}
		}

		#####################################################################################
		$del_query = "DELETE from fundings WHERE app_id='$id'";
		## execute the row deletion based on ID.
		$result = mysql_query($del_query, $dbhandle);
		## check if it was successful (should return true if successful)
		if (!$result) {
			## not successful, print error message, and print mysql_error
			$errno = mysql_errno($dbhandle);
			if ( ! array_key_exists($errno, $error_codes) ) {
				array_push($error_codes, $errno);
			}
		} else {
			## print to messages of successful 'fundings' table deletion.
			if (mysql_affected_rows($dbhandle)) {
				$messages .= "Fundings table - deletion success.<br/>";
			} else {
				$messages .= "Fundings table - ID does not exist.<br/>";
			}
		}

		#####################################################################################
		$del_query = "DELETE from publications WHERE app_id='$id'";
		## execute the row deletion based on ID.
		$result = mysql_query($del_query, $dbhandle);
		## check if it was successful (should return true if successful)
		if (!$result) {
			## not successful, print error message, and print mysql_error
			$errno = mysql_errno($dbhandle);
			if ( ! array_key_exists($errno, $error_codes) ) {
				array_push($error_codes, $errno);
			}
		} else {
			## print to messages of successful 'publications' table deletion.
			if (mysql_affected_rows($dbhandle)) {
				$messages .= "Publications table - deletion success.<br/>";
			} else {
				$messages .= "Publications table - ID does not exist.<br/>";
			}
		}

		#####################################################################################
		$del_query = "DELETE from summary_log WHERE app_id='$id'";
		## execute the row deletion based on ID.
		$result = mysql_query($del_query, $dbhandle);
		## check if it was successful (should return true if successful)
		if (!$result) {
			## not successful, print error message, and print mysql_error
			$errno = mysql_errno($dbhandle);
			if ( ! array_key_exists($errno, $error_codes) ) {
				array_push($error_codes, $errno);
			}
		} else {
			## print to messages of successful 'summary_log' table deletion.
			if (mysql_affected_rows($dbhandle)) {
				$messages .= "Summary_log table - deletion success.<br/>";
			} else {
				$messages .= "Summary_log table - ID does not exist.<br/>";
			}
		}

		## close the database
		closeDB($dbhandle);		
		
		## build errormessage if error_codes exist
		if (!empty($error_codes)) {
				$emessages .= "Access to database denied. $error_codes[0]";
		}
	}

	#######################################################################################################
	## check if the form was set and the submit button 'delete_id' was set.
	if (isset($_POST['delete_id']) && ($_POST['delete_id'] === "Delete")) {
		## ok, the delete button was pressed. now check
		## if appid exists and has a valid number.
		if (isset($_POST['appid']) && is_int_val($_POST['appid']) ) {
			## ok, appid exits and is a valid integer. lets try to delete the application data.	
			removeApplicationByID((int)$_POST['appid']);
			### enter deletion code here.
			
		} else { 
			## oops, it looks like the appid has bad data or is not set. set error message
			## to the $messages var.
			$emessages .= "Invalid Application ID entered. ID must be a valid integer. Please try again.";
		}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../content/collaborator.css" media="screen" type="text/css" rel="stylesheet" rev="stylesheet" />
<title>Audit Collaborator Collaborator database</title>
</head>

<body>
<?php include("header.inc"); ?>
<h1>Delete Application from  Collaborator database </h1>
<table width="750" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><p class="">On this page you can remove erronous/bad applications data from all the 
           Collaborator database tables. <br>Once you have determined a bad record based on the application data, use the Application ID, 
           <br>to remove the all references to the application.
        </p>
    </td>
  </tr>
</table>
<?php
	if ($emessages) {
		print "<p class='errormsg'>" . $emessages . "</p>\n";
	} else {
		if ($messages) {
			print "<p class='validmsg'>" . $messages . "</p>\n";
		}
	}
?>
<table width="750" border="0" cellpadding="2" cellspacing="2" class="outline">
  <tr>
    <td colspan="2" bgcolor="#FFFF00"><span class="errormsg ">WARNING</span> - Application, Funding, Publications, 
        and Summary data based on the application ID will be deleted from the database and cannot be undone.</td>
  </tr>
  <tr>
    <td class="fieldDescription">Enter the Application ID to remove:</td>
    <td><form id="remove_app" name="remove_app" method="post" action="audit-db.php">
	<table border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td width="60"><input name="appid" type="text" id="appid" size="10" /></td>
    <td width="64"><div align="right">
      <input name="delete_id" type="submit" id="delete_id" value="Delete" />
    </div></td>
  </tr>
</table>
    </form>    </td>
  </tr>
</table>

<p>&nbsp;</p>
<?php include("footer.inc"); ?>
</body>
</html>
