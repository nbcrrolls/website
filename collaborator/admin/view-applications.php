<?php
	require_once("../content/accountInfo.php");
	require_once("../content/dataArrays.php");
	require_once("../content/databaseFunctions.php");
	
	## page vars
	$status_type="";
	
	## open the database
	$dbHandle = openDBview();
	
	## init page for pagination.
	$page = 1;
	## Pagination code - used to paginate the records if more than 50 records.
	if ( isset($_GET['page']) && preg_match("/^\d+$/", $_GET['page']) ) {
	   $page = $_GET['page'];
	} else {
	   $page = 1; ## default
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
				$status_type = "active";
				break;
			## select inactive applications.
			case 'inactive':
				$query .= "where status='inactive'";
				$status_type = "inactive";
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
	} else { ## use status from POST  
		if (isset($_POST['status']) && !empty($_POST['status'])) {
			$status_type = $_POST['status'];
			if ($status_type != "") {
				$query .= "where status='$status_type'";
			}
		} else { ## no status set in POST -  view all applications
			$status_type = "";
		}
	}

	## since the most recent application is based on a higher id, order by the
	## highest id which will corelate to the most recent based dated entry.
	$query .= " order by id desc";

	## call the query, to get max count of available records from applications table.
	$applicantArr = mysql_query($query, $dbHandle);

	## get the number of records from the applications table. we will use this for pagination and output.
	$numOfRecords = mysql_num_rows($applicantArr);
	
	## calculate the last page number based on the max records per page.
	$recordsPerPage = 10;
	$lastpage = ceil($numOfRecords/$recordsPerPage);
	if ($lastpage < 1) {
		$lastpage = 1;
	}
	
	## get the current page set from $_GET['page'] set earlier. This section validates if
	## the current page is in range.
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

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NBCR Collaborator Application Status Update</title>
<link href="../content/collaborator.css" media="screen" type="text/css" rel="stylesheet" rev="stylesheet" />
</head>

<body>
<h1>View NBCR Collaborator Applications </h1>
<center>
<p>Choose desired application status from the menu: 
<form id="form1" name="form1" method="post" action="view-applications.php">
		<select name="status" class="field">
			<option value="">Choose status ...</option>
			<option value="New" >New</option>
			<option value="Approved">Approved</option>
			<option value="Active">Active</option>
			<option value="Inactive">Inactive</option>
			<option value="Rejected">Rejected</option>
			<option value="Pending">Pending</option>
			<option value="Completed">Completed</option>
		</select>
		<input name="update_status" type="submit" style="position:relative" id="update_status" value="Update" />
	</form>
</p>
<h3>Viewing applications by <?php empty($status_type) ? print "Application ID" : print 'status "' . $status_type . '"'; ?></h3>
</center>

<?php
	if($numOfRecords) { ## print the results
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
		## End pagination section 

		print<<<THEAD
			<table width='85%' border='1' cellpadding='2' cellspacing='0' class='outline'>
			    <tr class='header'>
				<td class='fieldDescription' width='75'><div align='center'> Application</div> </td>
				<td class='fieldDescription' width='100'><div align='center'>PI</div></td>
				<td class='fieldDescription' width='100'><div align='center'>Applicant</div></td>
				<td class='fieldDescription' width='100'><div align='center'>Research Area </div></td>
				<td class='fieldDescription' width='200'><div align='center'>Project Title </div></td>
				<td class='fieldDescription' width='200'><div align='center'>Organization/Laboratory</div></td>
				<td class='fieldDescription'><div align='center'>Resources</div></td>
			    </tr>
THEAD;
		$count = 0;
		while($row = mysql_fetch_row($applicantArr)) { ## print data.
			if ($count/2) {
				$bg = 'odd';
			} else { 
				$bg = 'even';
			};
			print<<<EOT
				  <tr class='{$bg}'>
					<td class='results'>ID: <a href='view-applicant.php?id={$row[$applicationTable['id']]}' target='_blank'>
						{$row[$applicationTable['id']]}</a></br>
					    Date: {$row[$applicationTable['date']]}
					</td>
					<td class='results'>{$row[$applicationTable['pi_first_name']]} {$row[$applicationTable['pi_last_name']]}</td>
					<td class='results'>{$row[$applicationTable['app_first_name']]} {$row[$applicationTable['app_last_name']]}</td>
					<td class='results'>{$row[$applicationTable['research_area']]}</td>
					<td class='results'>{$row[$applicationTable['project_title']]}</td>
					<td class='results'>
						{$row[$applicationTable['lab']]}</br>
						{$row[$applicationTable['department']]}</br>
						{$row[$applicationTable['institution']]}
					</td>
					<td class='results'><b>Software:</b> {$row[$applicationTable['resource_software']]}<br>
					                    <b>Hardware:</b> {$row[$applicationTable['resource_computer']]}
					</td>
				  </tr>
EOT;
			$count += 1;
		}
		print "</table><br/>";
	} else { ## false, no results
		print mysql_error();
	}
	## close the database
	closeDB($dbHandle);

?>

<?php 
	## this section prints out the pagination stuff.
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
?>
</body>
</html>
