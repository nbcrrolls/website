<?php
	#########################################################################################################
	## This script/php updates the applicants full summary and abstract portions of the application.
	#########################################################################################################

	require_once("../content/common.php");
        require_once("../content/accountInfo.php");
        require_once("../content/dataArrays.php");
        require_once("../content/functions.php");
        require_once("../content/databaseFunctions.php");

	#checkLogin();

	## init local variables
	$uid = NULL;
	$emessages = "";
	$messages = "";
	$applicantData = array();
	$errorField = array();
	## flag for inital summaries query
	$qsummary = false;
	$initalAppData_sum = false;
	$initalAppData_abs = false;

	#########################################################################################################
	##### Start -  get full and abs summaries based on id. ##################################################
	#########################################################################################################
	if (!$qsummary) {
		if (isset($_GET['id']) ) {
			## get the id number // check if number
			$uid = $_GET['id'];
			if (is_int_val($uid)) {
				## cast uid to int for sanity check
				$uid = (int)$uid;
				
				## open database
				$dbhandle = openDB();
				
				## create query
				$query = "select app_first_name, app_last_name, full_sum, abs_sum from applications where id=$uid";
				$result = mysql_query($query, $dbhandle);
				if (mysql_num_rows($result) == 1) {
					## gather the result of the applicant lookup to a local array.
					if ($row = mysql_fetch_row($result)) {
						## copy the resulting array
						$applicantData = array_merge($applicantData,$row);
						$qsummary = true;
					}
				} else {
					## the data is invalid or has more than one.
					##(clean up the db! only singleton id's should exist!)
				}
				closeDB($dbhandle);
				
			} else {
				## invalid application id. default to an empty page or error message
				## set applicantData() arr to empty strings.
				$applicantData = array (0 => "", 1 => "", 2 => "", 3 => "");
			}
		} else {
			## id not set. set array applicantData to empty string.
			## set applicantData() arr to empty strings.
			$applicantData = array (0 => "", 1 => "", 2 => "", 3 => "");
		}
		
	} ## end qsummary if statment block.

	############################################################################
	##### Apply button clicked:  update edited summaries and save old summaries
	############################################################################
	
	if ( (isset($_POST['apply_change'])) && ($_POST['apply_change'] === "Apply") && (isset($_POST['id'])) && (is_int_val($_POST['id'])) )  {
		$initalAppData_sum = true;
		$initalAppData_abs = true;

                $uid = $_POST['id'];
			
		## check required fields, if fields are empty, flag field.
		if (!checkInputfield($_POST, "mod_by", "/\w+/")) {
			$tmpErrorField = array ("mod_by" => "mod_by");
			$errorField = array_merge ($errorField,$tmpErrorField);
		} else { # fileds are ok
			## get old summaries to push to summary_log
			$dbhandle = openDB();
			$oldSummaries = array();
			## create query
			$query = "select full_sum, abs_sum from applications where id=$uid";
			$result = mysql_query($query, $dbhandle);
			if (mysql_num_rows($result) == 1) {
				## gather the result of the applicant lookup to a local array.
				if ($row = mysql_fetch_row($result)) {
					## copy the resulting array
					$oldSummaries = array_merge($oldSummaries,$row);
				}
			} else {
				## the data is invalid or has more than one.
				##(clean up the db! only singleton id's should exist!)
			}
			
			## generate date string (current)
			$date = date("Y-m-d H:i:s");
			$oldSummaries = cleanSQLData($oldSummaries,$dbhandle);
			$summary_full = !empty ($oldSummaries[0]) ? $oldSummaries[0] : '';
			$summary_abs = !empty ($oldSummaries[1]) ? $oldSummaries[1] : '' ;
			$mod_by = cleanSQLData($_POST['mod_by'], $dbhandle);
			
			## now, insert old summaries to the summary_log, app_id, timestamp, full_summary, modified_by, abs_sum
			$q_summary_log = "INSERT INTO summary_log (app_id, timestamp, full_summary, modified_by, abs_sum ) ";
			$q_summary_log .= "VALUES ($uid, '$date', '$summary_full', '$mod_by', '$summary_abs')";

			## insert into summary_log table.
			$result = mysql_query($q_summary_log, $dbhandle);
			if (mysql_affected_rows($dbhandle) < 0) {
				print "insert did not happen.";
				print "<br>$q_summary_log";
			}
				
			## after inserting the old summaries into the summary_log, update the new summaries into
			## the applications table
			$updated_summary_full = $_POST['full_sum'];
			$updated_summary_abs = $_POST['abs_summary'];
		
			$sqlcheck = array (
				"full" => $updated_summary_full,
				"abs" => $updated_summary_abs 
			);
		
			$sqlcheck = cleanSQLData($sqlcheck,$dbhandle);
			$q_updated_summaries = "UPDATE applications SET full_sum='".$sqlcheck['full']."', abs_sum='".$sqlcheck['abs']."' where id=$uid";

			## insert into summary_log table.
			$result = mysql_query($q_updated_summaries, $dbhandle);		
			if (mysql_affected_rows($dbhandle) < 0) {
				print "update did not happen.";
			}

			$messages .= "Summaries for Application ID '$uid' have been updated $date<br/>";
		} 
	
	} else {
		## apply_change button was not pressed or not set to "Apply"
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>NCMIR Collaborator - Update Application Summary</title>
<link href="../content/collaborator.css" media="screen" rel="stylesheet" rev="stylesheet" type="text/css" />

</head>

<body>
<?php include("../content/header.inc"); ?>

<h2>Update Application Summary</h2>
<p>For security reasons, the following characters or symbols <span class="star">&gt; | } &lt; { </span>
   are NOT allowed  and will be discarded. <br />
   Fields noted by an asterisk <span class="star">*</span> are required.</p>
<p>
   Note: Scientific notation will be changed or lost when copied from a wordprocessing package.<br />
   Note: Abstract text is for release to the NIH CRISP public database.  Do NOT include confidential material.<br/>
   Note: Summary text will not be released to the NIH CRISP database; however, it is subject to release under the Freedom of Information Act<br/>
</p>

<p>
<?php
  if (!empty($errorField)) {
    print "<span class='errormsg'>Some of the required fields are not set or not valid. Please re-enter the required fields denoted as *.</span>";
  } else {
    if ($messages) {
      print "<p class='validmsg'>$messages</p>";
    }
  }
?>
</p>

<form action="update-application-summary.php" method="post" target="_self">
<table border="1" cellpadding="2" cellspacing="2" class="outline">
  <tr>
    <td width="100" class="fieldDescription">Application ID</td>
    <td><?php isset($uid) && is_int_val($uid) && (0 < $uid) ? print "<a href='view-applicant.php?id=$uid' target='_blank'>$uid</a>" 
                                                            : print "<span class='errormsg'>No Application ID specified.</span>" ?></td>
    <td width="100" class="fieldDescription">Applicant's Name</td>
    <td><?php print $applicantData[0] ." ". $applicantData[1] ;?></td>
  </tr>

  <tr>
    <td colspan="4" class="fieldDescription">Abstract</td>
  </tr>

  <tr>
    <td colspan="4"><textarea name="abs_summary" cols="80" rows="10" class="field" id="abs_summary">
                    <?php
                        if (!$initalAppData_sum) {
		                    print $applicantData[3];
		                    $initalAppData_sum = true;
	                    } else {
		                    setInputValue("abs_summary");
	                    }
                    ?></textarea>
    </td>
  </tr>

  <tr>
    <td colspan="4" class="fieldDescription">Full Summary</td>
  </tr>

  <tr>
    <td colspan="4"><textarea name="full_sum" cols="80" rows="10" class="field" id="full_sum">
                    <?php
                        if (!$initalAppData_abs) {
		                    print $applicantData[2];
		                    $initalAppData_abs = true;
	                    } else {
		                    setInputValue("full_sum");
	                    }
                    ?></textarea>   
    </td>
  </tr>

  <tr>
    <td class="fieldDescription">Modified by <span class="star">*</span></td>
    <td width="200"><input name="mod_by" type="text" id="mod_by" class="<?php setInputStyle("mod_by"); ?>" value="<?php setInputValue("mod_by"); ?>" /></td>
    <td><input name="id" type="hidden" value="<?php print $uid; ?>" /><input name="cancel" type="submit" id="cancel" value="Cancel" /></td>
    <td> <input name="apply_change" type="submit" id="apply_change" value="Apply" /></td>
  </tr>
</table>
</form>

</body>
</html>
