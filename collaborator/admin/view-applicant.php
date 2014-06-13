<?php
        require_once("../content/accountInfo.php");
        require_once("../content/dataArrays.php");
        require_once("../content/databaseFunctions.php");
        require_once("../content/functions.php");

	## initialize local variables.
	## local array to store applicant data.
	$applicantData = array();
	$fundingsData = array();
	$publicationsData = array ();
	$uid = 0;

###################### print functions ########################

	## get the id from $_GET to query for applicant information.
	if (isset($_GET['id'])) {
		## get the id number // check if number
		$uid = $_GET['id'];
		if (is_int_val($uid)) {
			## cast uid to int for sanity check
			$uid = (int)$uid;
			## open the database
			$dbh = openDBview();

			######## APPLICATIONS QUERY ###############################################			
			$query = "select * from applications where id=$uid";
			## execute teh query based on the id.
			$result = mysql_query($query, $dbh);
			## check if the result is a single row (singleton record), if so get the data.
			if (mysql_num_rows($result) == 1) {
				## gather the result of the applicant lookup to a local array.
						if ($row = mysql_fetch_row($result)) {
							## copy the resulting array
							$applicantData = array_merge($applicantData,$row);
						}
			} else {
				## the data is invalid or has more than one.
				##(clean up the db! only singleton id's should exist!)
			}
			
			######## FUNDINGS QUERY ###################################################
			## get the fundings data from the fundings table
			$query = "select * from fundings where app_id=$uid";
			
			## execute the fundings query
			$result = mysql_query($query, $dbh);
			
			## get and collect the fundings from the table based from the id
			while ($row = mysql_fetch_row($result)) {
				## add row to fundingsData array
				array_push($fundingsData, $row);
			}

			######## PUBLICATIONS QUERY ###############################################
			## get the publications data from the publications table
			$query = "select * from publications where app_id=$uid";
			
			## execute the fundings query
			$result = mysql_query($query, $dbh);
			
			## get and collect the publications from the table based from the id
			while ($row = mysql_fetch_row($result)) {
				## add row to publicationsData array
				array_push($publicationsData, $row);
			}
			
			## close the database connection.
			closeDB($dbh);
		} else {
			## invalid id input. set all data arrays to empty.
			
		}
	} else {
		# id wasn't set. set all data arrays to empty.
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../content/collaborator.css" media="screen" type="text/css" rev="stylesheet" rel="stylesheet" />
<title>View NBCR Collaborator Application</title>
</head>

<body>
<h1>NBCR Collaborator Application - Full Listing</h1>
<h3>Applicant</h3>
<table width="750" border="1" cellpadding="1" cellspacing="2" class="outline">
  <tr>
    <td width="175" class="fieldDescription">Application ID:</td>
    <td width="200"><?php print $applicantData[$applicationTable['id']] ;?></td>
    <td width="175" class="fieldDescription">Date:</td>
    <td width="200"><?php print $applicantData[$applicationTable['date']] ;?></td>
  </tr>
  <tr>
    <td width="175" class="fieldDescription">Status</td>
    <td width="200"><?php print $applicantData[$applicationTable['status']] ;?></td>
    <td width="175" class="fieldDescription"><span class="fieldDescription">Status Date:</span></td>
    <td width="200"><?php print $applicantData[$applicationTable['status_date']] ;?></td>
  </tr>
  <tr>
    <td width="175" class="fieldDescription">First Name</td>
    <td width="200"><?php print $applicantData[$applicationTable['app_first_name']] ;?></td>
    <td width="175" class="fieldDescription">Last Name </td>
    <td width="200"><?php print $applicantData[$applicationTable['app_last_name']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Title</td>
    <td><?php print $applicantData[$applicationTable['app_title']] ;?></td>
    <td class="fieldDescription">Email</td>
    <td><?php print $applicantData[$applicationTable['app_email']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Phone Number </td>
    <td><?php print $applicantData[$applicationTable['app_phone']] ;?></td>
    <td class="fieldDescription">Degree</td>
    <td><?php print $applicantData[$applicationTable['app_degree']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Fax Number </td>
    <td><?php print $applicantData[$applicationTable['app_fax']] ;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<h3>Principal Investigator </h3>
<table width="750" border="1" cellpadding="1" cellspacing="2" class="outline">
  <tr>
    <td width="175" class="fieldDescription">First Name</td>
    <td width="200"><?php print $applicantData[$applicationTable['pi_first_name']] ;?></td>
    <td width="175" class="fieldDescription">Last Name </td>
    <td width="200"><?php print $applicantData[$applicationTable['pi_last_name']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Title</td>
    <td><?php print $applicantData[$applicationTable['pi_title']] ;?></td>
    <td class="fieldDescription">Email</td>
    <td><?php print $applicantData[$applicationTable['pi_email']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Phone Number </td>
    <td><?php print $applicantData[$applicationTable['pi_phone']] ;?></td>
    <td class="fieldDescription">Degree</td>
    <td><?php print $applicantData[$applicationTable['pi_degree']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Fax Number </td>
    <td><?php print $applicantData[$applicationTable['pi_fax']] ;?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<h3>Laboratory/Organization Information</h3>
<table width="750" border="0" cellpadding="1" cellspacing="2" class="outline">
  <tr>
    <td width="175" class="fieldDescription">Institution</td>
    <td width="200"><?php print $applicantData[$applicationTable['institution']] ;?></td>
    <td width="175" class="fieldDescription">Address </td>
    <td width="200"><?php print $applicantData[$applicationTable['street1']] ;?><br>
        <?php print $applicantData[$applicationTable['street2']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Department</td>
    <td><?php print $applicantData[$applicationTable['department']] ;?></td>
    <td class="fieldDescription">City and State</td>
    <td><?php print $applicantData[$applicationTable['city']] ;?>, 
        <?php print $applicantData[$applicationTable['state']] ;?></td>
    </td>
  </tr>
  <tr>
    <td class="fieldDescription">Organization/Lab</td>
    <td><?php print $applicantData[$applicationTable['lab']] ;?></td>
    <td class="fieldDescription">Postal Code  </td>
    <td><?php print $applicantData[$applicationTable['zip']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Major Research Area </td>
    <td><?php print $applicantData[$applicationTable['research_area']] ;?></td>
    <td class="fieldDescription">Country </td>
    <td><?php print $applicantData[$applicationTable['country']] ;?></td>
  </tr>
</table>

<h3>Project Information</h3>
<table width="750" border="1" cellpadding="1" cellspacing="2" class="outline">
  <tr>
    <td width="175" class="fieldDescription">Research Area </td>
    <td><?php print $applicantData[$applicationTable['research_area']] ;?></td>
  </tr>
  <tr>
    <td width="175" class="fieldDescription">Project Status </td>
    <td><?php print $applicantData[$applicationTable['app_type']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Project Title</td>
    <td><?php print $applicantData[$applicationTable['project_title']] ;?></td>
  </tr>
  <tr>
    <td width="175" class="fieldDescription">Keywords</td>
    <td><?php print $applicantData[$applicationTable['keywords']] ;?></td>
  </tr>
</table>


<h3>Abstract and Summary  </h3>
<table width="750" border="1" cellpadding="1" cellspacing="2" class="outline">
  <tr>
    <td class="fieldDescription" valign="top">Abstract</td>
    <td><?php print $applicantData[$applicationTable['abs_sum']] ;?><br /><br /></td>
  </tr>
  <tr>
    <td width="175" class="fieldDescription" valign="top">Full Summary</td>
    <td><?php print $applicantData[$applicationTable['full_sum']] ;?><br />
    <br /></td>
  </tr>
</table>

<h3>Requested Resources </h3>
<table width="750" border="1" cellpadding="1" cellspacing="2" class="outline">
  <tr>
    <td width="175" class="fieldDescription">Software  </td>
    <td><?php print $applicantData[$applicationTable['resource_software']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Cluster/hardware</td>
    <td><?php print $applicantData[$applicationTable['resource_computer']] ;?></td>
  </tr>
</table>

<h3>Personnel provided by Applicant/PI</h3>
<table width="750" border="1" cellpadding="1" cellspacing="2" class="outline">
  <tr>
    <td width="175" class="fieldDescription">Will provide personnel? </td>
    <td width="200"><?php print $applicantData[$applicationTable['personnel']] ;?></td>
    <td width="175" class="fieldDescription">Personnel Title </td>
    <td><?php print $applicantData[$applicationTable['personnel_title']] ;?></td>
  </tr>
  <tr>
    <td width="175" class="fieldDescription">Personnel First Name </td>
    <td><?php print $applicantData[$applicationTable['personnel_first_name']] ;?></td>
    <td class="fieldDescription">Personnel Email </td>
    <td><?php print $applicantData[$applicationTable['personnel_email']] ;?></td>
  </tr>
  <tr>
    <td class="fieldDescription">Personnel Last Name </td>
    <td><?php print $applicantData[$applicationTable['personnel_last_name']] ;?></td>
    <td class="fieldDescription">Personnel Degree </td>
    <td><?php print $applicantData[$applicationTable['personnel_degree']] ;?></td>
  </tr>
</table>

<h3>Visits</h3>
<table width="750" border="1" cellpadding="1" cellspacing="2" class="outline">
  <tr>
    <td width="175" class="fieldDescription">Visit Frequency </td>
    <td><?php print $applicantData[$applicationTable['visits']] ;?> visits per <?php print $applicantData[$applicationTable['visits_per']] ;?></td>
  </tr>
</table>

<h3>Funding Sources</h3>
<table width="750" border="1" cellpadding="2" cellspacing="2" class="outline">
  <tr>
    <td class="fieldDescription"><div align="center">No </div></td>
    <td class="fieldDescription"><div align="center">Funding Source </div></td>
    <td class="fieldDescription"><div align="center">Grant Number </div></td>
    <td class="fieldDescription"><div align="center">Principal Investigator </div></td>
    <td class="fieldDescription"><div align="center">Title</div></td>
    <td class="fieldDescription"><div align="center">Period</div></td>
  </tr>

<?php
	## print out all the funding information stored in the $fundingsData array
	$fundingCounter = 0;
	foreach ($fundingsData as $fundings_row_data) {
		print "<tr>\n";
		print "<td width='15' class='fieldDescription'><div align='center'>". ++$fundingCounter ."</div></td>\n";
		print "<td><div align='center'>". $fundings_row_data[$fundingsTable['source']] ."</div></td>\n";
		print "<td><div align='center'>". $fundings_row_data[$fundingsTable['grant_info']] ."</div></td>\n";
		print "<td><div align='center'>". $fundings_row_data[$fundingsTable['pi_first_name']] 
                      ." ". $fundings_row_data[$fundingsTable['pi_last_name']] ."</div></td>\n";
		print "<td><div align='center'>". $fundings_row_data[$fundingsTable['title']] ."</div></td>\n";
		print "<td><div align='center'>". $fundings_row_data[$fundingsTable['period']] ."</div></td>\n";
		print "</tr>\n";
	}
?>
</table>


<h3>Publication References</h3>
<table width="750" border="1" cellpadding="2" cellspacing="2" class="outline">
<?php
	## print out all the funding information stored in the $fundingsData array
	$publicationsCounter = 0;
	foreach ($publicationsData as $publications_row_data) {
		print "<tr>\n";
		print "<td width='15' class='fieldDescription'><div align='center'>". ++$publicationsCounter ."</div></td>\n";
		##print "<td><div align='center'>". $publications_row_data[$publicationsTable['type']] ."</div></td>\n";
		print "<td>". $publications_row_data[$publicationsTable['reference']] ."</td>\n";
		print "</tr>\n";
	}
?>
</table>

<p>&nbsp;</p>
</body>
</html>
