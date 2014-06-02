<?php
	################################################################################################
	## File: databaseFunctions.php 
	## Description: contains database functions to insert/select data from the collaborator database.
	################################################################################################
	
	## applications fields. This holds the applications table fields(indexes) used for sql queries.
/*
	$applicationFields = array (
		"date",
		"pi_first_name",
		"pi_last_name",
		"app_first_name",
		"app_last_name",
		"pi_title",
		"app_title",
		"pi_degree",
		"app_degree",
		"pi_phone",
		"app_phone",
		"pi_fax",
		"app_fax",
		"pi_email",
		"app_email",
		"lab",
		"department",
		"institution",
		"street1",
		"street2",
		"city",
		"state",
		"zip",
		"country",
		"research_area",
		"project_title",
		"keywords",
		"app_type",
		"abs_sum",
		"resource_software",
		"resource_computer",
		"personnel",
		"personnel_first_name",
		"personnel_last_name",
		"personnel_title",
		"personnel_email",
		"visits",
		"visits_per",
		"status",
		"status_date",
		"personnel_degree",
		"full_sum"
	);

	## applications array. This holds the applications table fields(indexes) used for sql queries.
	$applicationTable = array (
		"id" => 0,
		"date" => 1,
		"pi_first_name" => 2,
		"pi_last_name" => 3,
		"app_first_name" => 4,
		"app_last_name" => 5,
		"pi_title" => 6,
		"app_title" => 7,
		"pi_degree" => 8,
		"app_degree" => 9,
		"pi_phone" => 10,
		"app_phone" => 11,
		"pi_fax" => 12,
		"app_fax" => 13,
		"pi_email" => 14,
		"app_email" => 15,
		"lab" => 16,
		"department" => 17,
		"institution" => 18,
		"street1" => 19,
		"street2" => 20,
		"city" => 21,
		"state" => 22,
		"zip" => 23,
		"country" => 24,
		"research_area" => 25,
		"project_title" => 26,
		"keywords" => 27,
		"app_type" => 28,
		"abs_sum" => 29,
		"resource_software" => 30,
		"resource_computer" => 31,
		"personnel" => 32,
		"personnel_first_name" => 33,
		"personnel_last_name" => 34,
		"personnel_title" => 35,
		"personnel_email" => 36,
		"visits" => 37,
		"visits_per" => 38,
		"status" => 39,
		"status_date" => 40,
		"personnel_degree" => 41,
		"full_sum" => 42
	);
*/

	########################################################################################################################
	##### Database functions DO NOT EDIT ###################################################################################
	########################################################################################################################

	#####
	## Cleans the data array or singleton string. just in case the input has SQL injection,
	## escapes/cleans the input string.
	#####
	function cleanSQLData($arr, $conn) {

		## check if magic quotes is set on,, if so strip slashes.
		if(get_magic_quotes_gpc()) {
			if (is_array($arr)) {
	
				foreach ($arr as $key => $val) {
					## unquotes strings, if magic quotes is set on. (process arrya of strings)
					$arr[$key] = stripslashes($val);
				}
			} else {
				## process singleton string.
				$arr = stripslashes($arr);
			}
        } else {
			## data is not magic quoted, do nothing.
        }

		## Now check if the string is sql friendly, if not clean up string(s).
		if (is_array($arr)) {
			## now prep each string to make sure it is sql friendly. (process array of strings)
			foreach($arr as $key => $val) {
				$arr[$key] = mysql_real_escape_string($val,$conn );
			}
		} else {
			## process singleton string.
			$arr = mysql_real_escape_string($arr,$conn);
		}
		## return the processed data.
		return $arr;
	} ## end of cleanSQLData


	##### opens the mysql database.  #####
	function openDB() {
		global $UseradminU, $UseradminP, $UseradminD, $dbhost;
		## attempt to connect to the database.
		$dbhandle = mysql_connect($dbhost,$UseradminU,$UseradminP);
		#mysql_select_db($UseradminD,$dbhandle) or die( "Unable to select database");
                mysql_select_db($UseradminD,$dbhandle) or die('Can\'t use database : '.mysql_error());
		return $dbhandle;
	}

	##### opens the mysql database for view access.  #####
	function openDBview() {
		global $UserpiU, $UserpiP, $UserpiD, $dbhandle, $dbhost;
		## attempt to connect to the database.
		$dbhandle = mysql_connect($dbhost,$UserpiU,$UserpiP);
		mysql_select_db($UserpiD,$dbhandle) or die('Can\'t use database : '.mysql_error());
		return $dbhandle;
	}


	##### closes the mysql database  #####
	function closeDB($dbh) {
		global $dbhandle;
		## if exists, use dbhandle and close it.
		if ($dbh) {
			mysql_close($dbh);
		} else {
			## param dbh done, close the default dbhandle.
			mysql_close($dbhandle);
		}
	}


	##### returns a list of applicants. the parameter is the database dbHandle #####
	function getApplicants($dbh) {
		## get the database handle      
		## if dbh handle dne, return false.
		if (!$dbh) {
			return false;
		}
		$query = "select date, id, app_first_name, app_last_name from applications order by id";

		## call the query using the db handle.
		$result = mysql_query($query, $dbh);
		## return the result.   
		return $result;
	}


?>
