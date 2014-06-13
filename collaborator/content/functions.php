<?php
        ## Check if a number is a counting number by checking if it
        ## is an integer primitive type, or if the string represents an integer as a string
        function is_int_val($data) {
                if (is_int($data) === true) return true;
                elseif (is_string($data) === true && is_numeric($data) === true) {
                        return (strpos($data, '.') === false);
                }
                return false;
        }

	## generic input field check/validation function to test if the input field exists and is valid. 
	## returns true if valid, false if dne, or false if invalid.
	function checkInputfield() {
		## local variables init.
		$postVar = 0;
		$inputFieldName = 0;
		$rExp = 0;
		## collect the argument parameters there should be ony 2,3 arguments
		## where the 3rd arguement is a regular exp (optional)
		if (func_num_args() == 2) {
			## set the variables
			$postVar = func_get_arg(0);
			$inputFieldName = func_get_arg(1);
		} else {
			if (func_num_args() == 3) {
				## set the variables
				$postVar = func_get_arg(0);
				$inputFieldName = func_get_arg(1);
				$rExp = func_get_arg(2);
			} else {
				print "error: invalid arguments";
				return false;
			}
		}
		## check if $postVar is an array if not return false.
		if ( !is_array($postVar) ) {
			return false;
		}
		## check if fieldName is set.
		if ( !$inputFieldName ) {
			return false;
		}
		## check if rExp is set (used for regular expression checking)
		if ( !$rExp ) {
			## use default regular exp (ie: more than 0 apha characters)
			$rExp = "/.*/";
		}
		## check if variable was set in postVar
		if ( $postVar["$inputFieldName"] ) {
			## check if the input has valid data.
			$tmpValue = trim($postVar["$inputFieldName"]);
			
			if ( preg_match($rExp,$tmpValue) ) {
				return true;
			} else {
				return false;
			}
		}
		## return false, since field input and value does not exist.
		return false;
	} ## end checkInputfield


	## print the Input field value from the POST variable.
	## This is used to restore the data when the form is posted back (when the form is incomplete.)
	function setInputValue() {
		global $_POST;
		$name = func_get_arg(0);
		if ($name) {
			## name field exists from parameters, now check if it exist from $_POST
			if (isset($_POST[$name])) {
				## print the value stored in $_POST['$name']
				print $_POST[$name];
			} 
		}
	}


	##  sets the input style for the input fields.
	##  There are 2 types of styles which can be set:
	##    - field - normal style/fonts
	##    - error - red background-color for error field set via errorField array.
	function setInputStyle() {
		## get access to errorField array
		global $errorField;
		## get the first argument which is the input name
		$key = func_get_arg(0);
		## if no args set, print the default input style.
		if ($key) {
			if (!empty($errorField)) {
				if (array_key_exists($key, $errorField)) {
					print "error";
				} else {
					print "field";
				}
			} else {
				print "field";
			}
		} else {
			print "field";
		}
	} ## end of setInputStyle function


    function checkLogin() {
        if ($_SERVER['SERVER_NAME'] == 'nbcr.ucsd.edu') {
            ## do nothing
        } else {
            ## make sure we are SSL'ed
            if(empty($_SERVER['HTTPS'])) {

                if (!empty($_SERVER['QUERY_STRING'])) {
                    header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING']);
                    exit;
                } else {
                    header("Location: https://".$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME']);
                    exit;
                }

            }
        }

        session_start();
        global $httpBase, $webPath;
        ## check to make sure the session variable is registered 
        if(session_is_registered('username')) {
            ## the session variable is registered, the user is allowed to see anything that follows 
        }
        else {
            ## the session variable isn't registered, send them back to the login page 
            header( "Location: ".$httpBase . $webPath. "login.php" );
        }
    }

    ##### checks if the string is one of the status choices.
    function isValidStatus ($s) {
        if (!isset($s) || empty($s)) {
            return false;
        }
   
        $s = strtolower($s);
   
        $validArr = array (
            "new",
            "approved",
            "active",
            "inactive",
            "rejected",
            "pending",
            "completed"
        );
   
        if (in_array($s, $validArr, true)) {
            return true;
        } else {
            return false;
        }
    }

?>

