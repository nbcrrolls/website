<?php
	#########################################################################################################################
	## makes changes to the status portion on the User application. If set to approved,
	## an addition INSERT of the applicant goes int the approved table.
	#########################################################################################################################
        require_once("../content/common.php");
        require_once("../content/accountInfo.php");
        require_once("../content/dataArrays.php");
        require_once("../content/functions.php");
        require_once("../content/databaseFunctions.php");

	#checkLogin();

	## page vars
	$status_type = "";

	#########################################################################################################################
	####### BEGIN - if POST set with update status, process the modified status value #######################################
	#########################################################################################################################	
	if ( isset($_POST['update_status']) && ($_POST['update_status'] === "Update") && isset($_POST['status_id']) && 
					is_int_val($_POST['status_id']) && isset($_POST['status']) && isValidStatus($_POST['status']) ) {
		## get appID to update status.
		$post_id = (int) $_POST['status_id'];
		
		## get the current date mm/dd/yyyy
		$current_date = date("m/d/Y");
		
		## get status from post
		$post_status = $_POST['status'];
			
		## create update query based on the status
		$update_status_query = "UPDATE applications SET status='$post_status', status_date='$current_date' WHERE id=$post_id";
	
		## open the database
		$dbhs = openDB();
		
		## start transaction
		mysql_query("BEGIN", $dbhs);
			
		## check if set to Approved. If so, add to approved table.
		if ( strtolower($post_status) === "approved" ) {
			# check if already exists. if so disregard.
			$check_approvec_q = "SELECT * FROM approved WHERE id=$post_id";
			## execute query
			$r = mysql_query($check_approvec_q,$dbhs);
			## if the id DNE in approved table, add it
			if (mysql_num_rows($r) < 1) {
				$insert_id_q = "INSERT INTO approved SET id=$post_id";
				mysql_query($insert_id_q,$dbhs);
			}
		}
		
		## update the applications table for the status and status_date
		mysql_query($update_status_query, $dbhs);
	
		## commit the database changes.
		mysql_query("COMMIT", $dbhs);
		
		## close the database
		closeDB($dbhs);
	}
	
	## create default query used for applicant output and pagination
	$query = "select * from applications ";

	if (isset($_GET['status']) && !empty($_GET['status'])) {
		## if status is set, get the status type and set the remaining query.
		switch(strtolower($_GET['status'])) {
			## select new applications.
			case 'new':
				$query .= "where status='new'";
				$status_type = "New";
				break;
			## select approved applications.
			case 'approved':
				$query .= "where status='approved'";
				$status_type = "Approved";
				break;
			## select new applications.
			case 'active':
				$query .= "where status='active'";
				$status_type = "Active";
				break;
			## select inactive applications.
			case 'inactive':
				$query .= "where status='inactive'";
				$status_type = "Inactive";
				break;
			## select rejected applications.
			case 'rejected':
				$query .= "where status='rejected'";
				$status_type = "Rejected";
				break;
			## select pending applications.
			case 'pending':
				$query .= "where status='pending'";
				$status_type = "Pending";
				break;
			## select completed applications.
			case 'completed':
				$query .= "where status='completed'";
				$status_type = "Completed";
				break;
			## default query
			default:
				$query .= "where status='new'";
				$status_type = "New";
		}
	}

	## order by the highest id which will corelate to the most recent based dated entry.
	$query .= " order by id desc";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NCMIR Collaborator - Update Application Status</title>
<link href="../content/collaborator.css" media="screen" rel="stylesheet" rev="stylesheet" type="text/css" />
</head>

<body>
<?php include("../content/header.inc"); ?>
<h1>Update Application Status </h1>
<h3>Current application status view is <?php (isset($status_type)) ? print $status_type : print "New"; ?></h3>
<form action="<?php print $_SERVER['PHP_SELF']; ?>" method="get" name="change-status" target="_self" id="change-status">
<table class="" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><select name="status" class="" id="status">
			  				<option value='New' selected >New</option>
							<option value='Approved'>Approved</option>
							<option value='Active'>Active</option>
							<option value='Inactive'>Inactive</option>
							<option value='Rejected'>Rejected</option>
							<option value='Pending'>Pending</option>
							<option value='Completed'>Completed</option>
          </select></td>
          <td><input name="setStatus" type="submit" id="setStatus" value="Change status view" />
          </td>
        </tr>
  </table></form>

<?php
	## open the database
	$dbHandle = openDB();
	
	## init page for pagination.
	$page = 1;
	## Pagination code - used to paginate the records if more than 50 records.
	if ( isset($_GET['page']) && preg_match("/^\d+$/", $_GET['page']) ) {
	   $page = $_GET['page'];
	} else {
	   $page = 1; ## default
	}

	## call the query which was built up in the first section, to get max count of available records from applications table.
	$applicantArr = mysql_query($query, $dbHandle);

	## get the number of records from the applications table. we will use this for pagination and output.
	$numOfRecords = mysql_num_rows($applicantArr);
	
	## calculate the last page number based on the max records per page.
	$recordsPerPage = 10;
	$lastpage = ceil($numOfRecords/$recordsPerPage);
        if ($lastpage < 1) {
        	$lastpage = 1;
        }
	
	## get rhe current page set from $_GET['page'] set earlier. This section validates if the current page is in range.
	$page = (int)$page;
	if ($page < 1) {
		$page = 1;
	} elseif ($page > $lastpage) {
		$page = $lastpage;
	}
	
	## create the mysql limit clause to paginate/limit the number of records to display. 
	$limit = 'LIMIT ' .($page - 1) * $recordsPerPage .',' .$recordsPerPage;

	## add it to the built query set earlier.
	$query .= " $limit";

	## call the query with the limit clause, and gather the results.
	$applicantArr = mysql_query($query, $dbHandle);

	## get the number of records from the applications table. we will use this for the output.
	$numOfRecords = mysql_num_rows($applicantArr);

	if($numOfRecords) {
		## Start pagination section - this prints out the pagination stuff.
		$status_link = isset($status_type) && !empty($status_type) ? "&status=$status_type" : "";
		## get the current page
		$current_page = "?page=$page";
		
		print "<p class='paginate-section'>\n";
		if ($page == 1) {
			print " FIRST PREV ";
		} else {
			print "<a href='" . $_SERVER['PHP_SELF'] . "?page=1$status_link'>FIRST</a> ";
			$prevpage = $page-1;
			print "<a href='" . $_SERVER['PHP_SELF'] . "?page=$prevpage$status_link'>PREV</a> ";
		}
	
		print " ( Page $page of $lastpage ) ";
	
		if ($page == $lastpage) {
			print " NEXT LAST ";
		} else {
			$nextpage = $page+1;
			print " <a href='" . $_SERVER['PHP_SELF'] . "?page=$nextpage$status_link'>NEXT</a> ";
			print " <a href='" . $_SERVER['PHP_SELF'] . "?page=$lastpage$status_link'>LAST</a> ";
		}
		print "</p>\n";
		## End pagination section - this prints out the pagination stuff. 

		while($row = mysql_fetch_row($applicantArr)) {
			## print out the data.
			print<<<EOT
				<table width="85%" border='1' cellpadding='2' cellspacing='2' class='outline'>
				  <tr>
					<td class='fieldDescription' width='100'>Application ID : <a href='view-applicant.php?id={$row[$applicationTable['id']]}' target='_blank'>{$row[$applicationTable['id']]}</a></td>
					<td class='fieldDescription' width='80'><div align='center'>Principal Investigator </div></td>
					<td class='fieldDescription' width='80'><div align='center'>Applicant</div></td>
					<td class='fieldDescription' width='80'><div align='center'>Research Area </div></td>
					<td class='fieldDescription' width='240'><div align='center'>Project Title </div></td>
					<td class='fieldDescription'><div align='center'>Resources</div></td>
					<td class='fieldDescription' width='100'><div align='center'>Status - Action </div></td>
				  </tr>
				  <tr>
					<td class='fieldDescription'>Application Date : {$row[$applicationTable['date']]}</td>
					<td>{$row[$applicationTable['pi_first_name']]} {$row[$applicationTable['pi_last_name']]}</td>
					<td>{$row[$applicationTable['app_first_name']]} {$row[$applicationTable['app_last_name']]}</td>
					<td>{$row[$applicationTable['research_area']]}</td>
					<td>{$row[$applicationTable['project_title']]}</td>
                                        <td><b>Software:</b> {$row[$applicationTable['resource_software']]}<br>
                                            <b>Hardware:</b> {$row[$applicationTable['resource_computer']]}
					</td>
					<td rowspan='2'>
					<form id='update_{$row[$applicationTable['id']]}' name='update_{$row[$applicationTable['id']]}' method='post' action='update-application-status.php$current_page$status_link'>
						<select name='status' class='field'>
							<option value='New' selected >New</option>
							<option value='Approved'>Approved</option>
							<option value='Active'>Active</option>
							<option value='Inactive'>Inactive</option>
							<option value='Rejected'>Rejected</option>
							<option value='Pending'>Pending</option>
							<option value='Completed'>Completed</option>
						</select><input name='status_id' id='status_id' type='hidden' value='{$row[$applicationTable['id']]}' />
						<input name='update_status' type='submit' id='update_status' value='Update' />
					</form></td>
				  </tr>
				  <tr>
					<td class='fieldDescription'>Organization / Lab</td>
					<td class='field' colspan='5'>
						{$row[$applicationTable['lab']]}, 
						{$row[$applicationTable['department']]}, 
						{$row[$applicationTable['institution']]}
					</td>
				  </tr>
				</table><br/>
EOT;
		}
	} else { ## false, no results
		print mysql_error();
	}
	## close the database
	closeDB($dbHandle);

?>

<?php 
	## Start pagination section - this prints out the pagination stuff.
	$status_link = isset($status_type) && !empty($status_type) ? "&status=$status_type" : "";
	print "<p class='paginate-section'>\n";
	if ($page == 1) {
		print " FIRST PREV ";
	} else {
		print "<a href='" . $_SERVER['PHP_SELF'] . "?page=1$status_link'>FIRST</a> ";
		$prevpage = $page-1;
		print "<a href='" . $_SERVER['PHP_SELF'] . "?page=$prevpage$status_link'>PREV</a> ";
	}

	print " ( Page $page of $lastpage ) ";

	if ($page == $lastpage) {
		print " NEXT LAST ";
	} else {
		$nextpage = $page+1;
		print " <a href='" . $_SERVER['PHP_SELF'] . "?page=$nextpage$status_link'>NEXT</a> ";
		print " <a href='" . $_SERVER['PHP_SELF'] . "?page=$lastpage$status_link'>LAST</a> ";
	}
	print "</p>\n";
	## End pagination section - this prints out the pagination stuff. 
?>

</body>
</html>
