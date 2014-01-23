<?php
	## open session
	session_start();
	## get the conmmon variables
	require_once("content/common.php");

	## database user info
	require_once("content/accountInfo.php");

	## require the database functions
	require_once("content/databaseFunctions.php");

	## if the 'sessionident' DNE in the superglobal $_SESSION array redirect to beginning start page.
	if (!isset($_SESSION['sessionident'])) {
		session_destroy();
		$_SESSION = array();
		header("Location:" . $httpBase . $webPath);
		exit;
	} else {
		## session is set, is it the same session as teh current session? if not redirect to start page.
		if ($_SESSION['sessionident'] !== session_id()) {
			session_destroy();
			$_SESSION = array();
			header("Location:" . $httpBase . $webPath);
			exit;
		}
	}

	#############################################################
	
	## open the database, and aquire the db handler
	$dbh = openDB();

	## prep the database to start a transaction (prevents having a race condition when selecting the next available index.)
	mysql_query("BEGIN", $dbh);

	## get all the keys from the application table EXCEPT id; id is generated automatically when an INSERT is executed.
	$application_fields = implode(",", $applicationFields);

	## get the validated values and fill in the fields for the 'applications' Table.
	## ORDER MATTERS HEAE!!!
	$application_data = array();
	array_push($application_data, $_SESSION["date"]);
	array_push($application_data, $_SESSION["pi_first_name"]);
	array_push($application_data, $_SESSION["pi_last_name"]);
	array_push($application_data, $_SESSION["app_first_name"]);
	array_push($application_data, $_SESSION["app_last_name"]);

	###################################################################################################################
	## push the pi_title to the applications array. if "other" was set,
	## push the 'other specified title'
	if (isset($_SESSION["pi_title"]) && $_SESSION["pi_title"] === "Other") {
		## set to other title input field
		if (isset($_SESSION["pi_title"]) && !empty($_SESSION["pi_title"])) {
			array_push($application_data, $_SESSION["pi_spec_title"]);
		} else {
			array_push($application_data, $_SESSION["pi_title"]);
		}
	} else {
		array_push($application_data, $_SESSION["pi_title"]);
	}	
	
	###################################################################################################################
	## push the app_title to the applications array. if "other" was set,
	## push the 'other specified title'
	if (isset($_SESSION["app_title"]) && $_SESSION["app_title"] === "Other") {
		## set to other title input field
		if (isset($_SESSION["app_title"]) && !empty($_SESSION["app_title"])) {
			array_push($application_data, $_SESSION["app_spec_title"]);
		} else {
			array_push($application_data, $_SESSION["app_title"]);
		}
	} else {
		array_push($application_data, $_SESSION["app_title"]);
	}
	###################################################################################################################

	array_push($application_data, $_SESSION["pi_degree"]);
	array_push($application_data, $_SESSION["app_degree"]);
	array_push($application_data, $_SESSION["pi_phone"]);
	array_push($application_data, $_SESSION["app_phone"]);
	array_push($application_data, $_SESSION["pi_fax"]);
	array_push($application_data, $_SESSION["app_fax"]);
	array_push($application_data, $_SESSION["pi_email"]);
	array_push($application_data, $_SESSION["app_email"]);
	array_push($application_data, $_SESSION["lab"]);
	array_push($application_data, $_SESSION["department"]);
	array_push($application_data, $_SESSION["institution"]);
	array_push($application_data, $_SESSION["street1"]);
	array_push($application_data, $_SESSION["street2"]);
	array_push($application_data, $_SESSION["city"]);

	###################################################################################################################
	## set 'state' to state (US) or province (non-US)
	if (isset($_SESSION["country"]) && $_SESSION["country"] === "US") {
	        array_push($application_data, $_SESSION["state"]);
	} else {
	        array_push($application_data, $_SESSION["province"]);
	}
	array_push($application_data, $_SESSION["zip"]);
	array_push($application_data, $_SESSION["country"]);
	array_push($application_data, $_SESSION["research_area"]);
	array_push($application_data, $_SESSION["project_title"]);
	array_push($application_data, $_SESSION["keywords"]);
	array_push($application_data, $_SESSION["app_type"]);
	array_push($application_data, $_SESSION["abs_sum"]);
	array_push($application_data, $_SESSION["resource_software"]);
	array_push($application_data, $_SESSION["resource_computer"]);
	array_push($application_data, $_SESSION["personnel"]);
	array_push($application_data, $_SESSION["personnel_first_name"]);
	array_push($application_data, $_SESSION["personnel_last_name"]);
	
	###################################################################################################################
	## push the personnel_title to the applications array. if "other" was set,
	## push the 'other specified title'
	if (isset($_SESSION["personnel_title_name"]) && $_SESSION["personnel_title_name"] === "Other") {
		## set to other title input field
		if (isset($_SESSION["personnel_title_name"]) && !empty($_SESSION["personnel_title_name"])) {
			array_push($application_data, $_SESSION["personnel_spec_title_name"]);
		} else {
			array_push($application_data, $_SESSION["personnel_title_name"]);
		}
	} else {
		if ($_SESSION["personnel_title_name"] != "default") {
			array_push($application_data, $_SESSION["personnel_title_name"]);
		} else {
			array_push($application_data, "");
		}
	}
	###################################################################################################################

	array_push($application_data, $_SESSION["personnel_email_name"]);
	array_push($application_data, $_SESSION["visits"]);
	array_push($application_data, $_SESSION["visits_per"]);

	array_push($application_data, "New"); ## status, = New, since this is the web form where applicants apply.
	array_push($application_data, $_SESSION["status_date"]);
	
	###################################################################################################################
	if ($_SESSION["personnel_degree"] != "default") {
		array_push($application_data, $_SESSION["personnel_degree"]);
	} else {
		array_push($application_data, "");
	}
	###################################################################################################################

	array_push($application_data, $_SESSION["full_sum"]);

	## clean up the data in preparation to insert into database table.
	$application_data = cleanSQLData($application_data,$dbh);

	## after the application data is preped, create the VALUES string from the application data array.
	$application_data_string = "'". implode("','",$application_data) . "'";

	## create an empty insert into applications. we need to get the ID from the INSERT
	$applications_query = "INSERT INTO applications ($application_fields) VALUES ($application_data_string)";

	## INSERT the application data into the database table.
        $result = mysql_query($applications_query, $dbh);
        if (!$result) {
            die('Invalid query: '.mysql_error());
            exit ();
        }
	
	## after inserting the data, get the id where the data was inserted at.
	$appID = mysql_insert_id($dbh);

	## commit the INSERT and close.
	mysql_query("COMMIT", $dbh);
	
	## close the database
	closeDB($dbh);

	#############################################################
	
	## prep the publications data.
	## get the validated values and fill in the fields for the 'publications' Table.
	$publications_data = array();
	for($i=1; $i <=5; $i++) {
		## if the publication is set and is not empty, add it into the publications_data array
		if (isset( $_SESSION["publication$i"]) && !empty($_SESSION["publication$i"])) {
			array_push($publications_data, $_SESSION["publication$i"]);
		}
	}

	## now insert the publications data.
	$dbh = 0; ## reset db handle.
	$dbh = openDB();


	## clean up the data in preparation to insert into database table.
	$publications_data = cleanSQLData($publications_data,$dbh);

	## start the transaction to the db.
	mysql_query("BEGIN", $dbh);

	## INSERT the publications_data into the publications table.
	foreach ($publications_data as $val) {
		## prep the insert statement into the publications table.
		$publications_query = "INSERT INTO publications (app_id,reference,type) VALUES($appID,'$val',NULL)";
		mysql_query($publications_query, $dbh);
	}

	## commit the INSERT and close.
	mysql_query("COMMIT", $dbh);
	
	## close the database
	closeDB($dbh);	

	#############################################################
	
	## prep the summary_log data
	
	## prep the form values to insert into summary log
	$summary_log_data = array();
	array_push($summary_log_data, date("Y-m-d H:i:s"));
	array_push($summary_log_data, $_SESSION["full_sum"]);
	array_push($summary_log_data, $_SESSION["abs_sum"]);
	array_push($summary_log_data, "ORIGINAL"); ## default data for modified_by field

	## now insert the summary_log data.
	$dbh = 0; ## reset db handle.
	$dbh = openDB();

	## clean up the data in preparation to insert into database table.
	$summary_log_data = cleanSQLData($summary_log_data,$dbh);	
	
	## after the summary_log data is preped, create the VALUES string from the summary_log_data array.
	$summary_log_data_string = "'". implode("','",$summary_log_data) . "'";
	
	## create the summary_log query
	$summary_log_query = "INSERT INTO summary_log (app_id, timestamp, full_summary, abs_sum, modified_by) VALUES ($appID, $summary_log_data_string)";

	## start the transaction to the db.
	mysql_query("BEGIN", $dbh);
		
	## INSERT data into the summary_log table
	mysql_query($summary_log_query, $dbh);

	## commit the INSERT and close.
	mysql_query("COMMIT", $dbh);
	
	## close the database
	closeDB($dbh);	

	#############################################################

	## prep the fundings data 
	## get the validated values and fill in the fields for the 'fundings' Table.

	## now insert the fundings data.
	$dbh = 0; ## reset db handle.
	$dbh = openDB();

	## start the transaction to the db.
	mysql_query("BEGIN", $dbh);
	
	for($i=1; $i <=5; $i++) {
		## if the publication is set and is not empty, add it into the publications_data array
		if ( (isset( $_SESSION["source$i"]) && !empty($_SESSION["source$i"])) && (isset( $_SESSION["grant$i"]) && !empty($_SESSION["grant$i"]))  && (isset( $_SESSION["pi_first_name$i"]) && !empty($_SESSION["pi_first_name$i"])) && (isset( $_SESSION["pi_last_name$i"]) && !empty($_SESSION["pi_last_name$i"]))  &&   (isset( $_SESSION["title$i"]) && !empty($_SESSION["title$i"])) &&  (isset( $_SESSION["period$i"]) && !empty($_SESSION["period$i"])) ) {

			## create the fundings data array
			$fundings_data = array();

			array_push($fundings_data, $_SESSION["source$i"]);
			array_push($fundings_data, $_SESSION["grant$i"]);
			array_push($fundings_data, $_SESSION["pi_first_name$i"]);
			array_push($fundings_data, $_SESSION["pi_last_name$i"]);
			array_push($fundings_data, $_SESSION["title$i"]);
			array_push($fundings_data, $_SESSION["period$i"]);
			
			## clean up the data in preparation to insert into database table.
			$fundings_data = cleanSQLData($fundings_data,$dbh);
			## after the funding data is preped, create the VALUES string from the funding_data array.
			$fundings_data_string = "'". implode("','",$fundings_data) . "'";
		
			## INSERT the fundings_data into the publications table.
			## prep the insert statement into the publications table.
			$fundings_query = "INSERT INTO fundings (app_id,source,grant_info,pi_first_name,pi_last_name,title,period) VALUES($appID, $fundings_data_string)";
			mysql_query($fundings_query, $dbh);			
		}
	}

	## commit the INSERT and close.
	mysql_query("COMMIT", $dbh);
	
	## close the database
	closeDB($dbh);	

	#############################################################

    if ($_SESSION["app_email"]) {
        $save_email = $_SESSION["app_email"];
        if ($_SESSION["app_first_name"]) {
            $Name = $_SESSION["app_first_name"];
        } else {
            $Name = "";
        }

        if ($_SESSION["app_last_name"]) {
            $Name = $Name . " " . $_SESSION["app_last_name"] . ",";
        } else {
            $Name = "Applicant,";
        }

        ## Send mail to recipient
	$to      = $_SESSION["app_email"] . ",admin@nbcr.net";
	$subject = 'Your NBCR Collaborator Application has been received.';
        $message = "Dear ". $Name . "\n\n" .
                   "Thank you for your Application submission.\n" .
                   "The NBCR Scientific Advisory Board meets monthly to review applications. \n" . 
                   "Questions, comments or status inquiries can be sent to XXXX or XXXX.". "\n" .
                   "http://nbcr.ucsd.edu ". "\n\n" ."National Biomedical Computation Research, UCSD";	
        $headers = 'From: admin@nbcr.ucsd.edu' . "\r\n" .
		   'Reply-To: admin@nbcr.net' . "\r\n";

	mail($to, $subject, $message, $headers);
	}

	## INSERTIONS are complete! destroy the session, and clear the superglobal $_SESSION array
	session_destroy();
	$_SESSION = array();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NBCR Collaborator Application is submitted for review</title>
<link href="content/collaborator.css" media="screen" type="text/css" rel="stylesheet" rev="stylesheet" />
</head>

<body>
<h1>NBCR Collaborator Application</h1>
<h5>Thank you, your Application has been submitted.</h5>
<p> Once the application is reviewed, you will receive a notification and additional <br>
    information at the email address <?php print $save_email; ?> supplied in the application.<br /><br />
    If you have further questions about this process, please contact us at: admin@nbcr.net <br /> <br />
    Click <a href="http://nbcr.ucsd.edu" target="_blank">here</a> to return to the NBCR main website.
</p>
</body>
</html>
