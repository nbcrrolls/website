<?php
	#######################################################################################
	## File: validate.php
	## Description: contains functions which validate the collaborator web form.
	#######################################################################################

	#######################################################################################
	#### Start - web form functions #######################################################
	#######################################################################################

	#####
	## Function checkCountryAndState()
	## This function checks if US is set, if so state is required.
	## params: none
	#####
	function checkCountryAndState() {
		## get access to POST and requiredfields variables.
		global $requiredFields, $errorField, $statesArr;
		global $_POST;
		$stateField = array("state"=>"state");
		$provinceField = array("province"=>"province");
		## check if 'country' is set.
		if (isset($_POST['country'])) {
			## check the value of 'country', if the value is 'US'
			## add the 'state' field to the required fields array.
			if ( $_POST['country'] === "US" ) {
				## check if state has data
				if (!isset($_POST['state'])) {
					## add 'state' field to the required fields array
					$requiredFields = array_merge($requiredFields,  $stateField);
				} else {
					## state exists. check if valid data
					if (  in_array($_POST['state'],$statesArr) && (preg_match("/[^default]/",$_POST['state'])) ) {
						## do nothing. its a valid state.
					} else {
						## not a valid state, add to errorArray
						$errorField = array_merge ($errorField,$stateField);
					}
				}			
			} else {
				## the country is not US
				#RMME $_POST['state'] = '';
				## check if province has data
				if (!isset($_POST['province'])) {
					## add 'province' field to the required fields array
					$requiredFields = array_merge($requiredFields,  $provinceField);
				} else {
					## province exists. check if valid data
					#RMMEif (  in_array($_POST['province'],$statesArr) && (preg_match("/[^default]/",$_POST['state'])) ) {
				        if (isset($_POST['province']) && preg_match("/\w+/",$_POST['province']) ) {
						## do nothing. its a valid state.
					} else {
						## not a valid state, add to errorArray
						$errorField = array_merge ($errorField,$provinceField);
					}
				}
			}
		} else {
			## default, add 'state' field as required until country field is set.
			$requiredFields = array_merge($requiredFields, $stateField);	
		}
	} ## End of checkCountryAndState function




	#####
	## Function checkTitle()
	## This function checks and set the applicant title fields.
	## Params:  inputname, otherInputname
	#####
	function checkTitle() {
		## get access tot eh errorField array
		global $errorField, $_POST;
		
		## get input name
		$name = func_get_arg(0);
		$othername = func_get_arg(1);
		
		if(isset($_POST[$name]) && preg_match("/[^default]/",$_POST[$name]) ) {
			if($_POST[$name] === "Other") {
				## check the othername var if set.
				if (isset($_POST[$othername]) && preg_match("/\w+/",$_POST[$othername]) ) {
					## good data, do nothing.
				} else {
					## data is bad/not set flag error.
					$tmpErrorField = array ($othername => $othername);
					$errorField = array_merge ($errorField,$tmpErrorField);
				}
			}
		}
	} ## end of checkTitle


	#####
	## Function: setSelectStyle()
	## This function sets the select input red if field is not selected.
	## This is similar to setInputStyle.
	#####
	function setSelectStyle() {
	
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
	} ## end of setSelectStyle function
	
	
	#####
	## function: setInputStyle()
	##  This function sets teh input style for the input fields.
	##  There are 2 types of styles which can be set:
	##    - field - normal style/fonts
	##    - error - red background-color for error field set via
	##              errorField array.
	#####
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
	
	
	#####
	## function: checkInputfield()
	## This function is a generic input field check/validation function
	## to test if the input field exists and is valid. This function
	## returns true if valid, false if dne, or false if invalid.
	#####
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
			$tmpValue = $postVar["$inputFieldName"];
			if ( preg_match($rExp,$tmpValue) ) {
				return true;
			} else {
				return false;
			}
		}
		## return false, since field input and value does not exist.
		return false;
	} ## end checkInputfield
	
	
	#####
	## Function: setInputValue()
	## print the Input field value from the POST variable.
	## This is used to restore the data when the form is posted back
	## (when the form is incomplete.)
	#####
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
	
	
	#####
	## Function: printSelect()
	## This function prints out the select input 'options' and also hights the
	## previous selection (based on users POST)
	#####
	function printSelect() {
		global $_POST;
		## get the 2 params: array of name->value, AND select input name.
		$selArr = func_get_arg(0);
		$name = func_get_arg(1);
		## validate params
		## check if 1st param is an array
		if (is_array(!$selArr)) {
			print "<option value='error'>error</option>\n";
		} else {
			## selArr is an array, now check if the second param exists
			if ($name) {
				## check if a value was set in the POST variable.
				## if set, set the value as selected, else print the default option stmt.
				if (isset($_POST[$name])) {
					## since selArr and name exist, print out the select input fields.
					foreach ($selArr as $nm => $val) {
						if (preg_match("/^$val$/", $_POST[$name])) {
							print "<option value='$val' selected='selected'>$nm</option>\n";
						} else {
							print "<option value='$val'>$nm</option>\n";
						}
					}
				} else {
					## post not set. print default.
					foreach ($selArr as $nm => $val) {
						print "<option value='$val'>$nm</option>\n";
					}
				}
			} else { ## name not set, print default.
				foreach ($selArr as $nm => $val) {
					print "<option value='$val'>$nm</option>\n";
				}
			}
		}
	}


	#####
	## function: setCheckboxInput()
	## This function sets the checkbox input as checked if the value has been set.
	#####
	function setCheckboxInput($inputName, $val) {
		global $_POST;
		
		## check if input checkbox was set
		if (isset($_POST[$inputName])) {
			## input checkbox was set, now check if the value is an array
			## if so, check the array if the value exists.
			if (is_array($_POST[$inputName])) {
				## ok, the input is an array, now search for teh value, if exist print checked since
				## the checkbox was selected.
				if (in_array($val, $_POST[$inputName])) {
					print "checked='checked'";
				} else {
					## do nothing. value does not exist in the input array 
				}
			} else {
				## the input value is not an array, check if the value is set
				if ($_POST[$inputName] === $val) {
					print "checked='checked'";
				} else {
					## do nothing. value doesn't equal the POSTed value
				}
			}
		} else {
			## checkbox not set. do nothing
		}
	} ## end of setCheckboxInput


	#####
	## function: setRadioInput()
	## This function sets the radio input as checked if the value has been set.
	#####
	function setRadioInput($inputName, $val) {
		global $_POST;
		
		## check if input checkbox was set
		if (isset($_POST[$inputName])) {
			## input radio was set, now check if the value is an array
			## if so, check the array if the value exists.
			if (is_array($_POST[$inputName])) {
				## ok, the radio is an array, now search for teh value, if exist print checked since
				## the radio was selected.
				if (in_array($val, $_POST[$inputName])) {
					print "checked='checked'";
				} else {
					## do nothing. value does not exist in the input array 
				}
			} else {
				## the input value is not an array, check if the value is set
				if ($_POST[$inputName] === $val) {
					print "checked='checked'";
				} else {
					## do nothing. value doesn't equal the POSTed value
				}
			}
		} else {
			## radio button not set. do nothing
		}
	} ## end of setRadioInput

	#######################################################################################
	#### End - web form functions #########################################################
	#######################################################################################

	#######################################################################################
	#### Start - Check Sections for Part 1 ################################################
	#######################################################################################


	#####
	## Function: checkProjectStatus()
	## This function checks if the project status is checked. (radio buttons)
	#####
	function checkProjectStatus() {
		global $_POST, $errorField;
		## check if the radio button was checked. if not highlight/flag the table
		if (!isset($_POST['app_type'])) {
			## add error to errors array
			$tmpErrorField = array ("app_type" => "app_type");
			$errorField = array_merge ($errorField,$tmpErrorField);
		} else {
			## do nothing. radio button isset
		}
	}
	
	
	#####
	## Function: setProjectSection()
	## This function prints the error style if either is in the error field.
	#####
	function setProjectSection() {
		global $errorField;
		if ( in_array("app_type", $errorField) ) {
			print "class='error'";
		}
	}
	
	
	#####
	## Function: checkResourcesSection()
	## This function checks if at least one resource section and network 
	## input(required) have been set. (radio and checkboxes buttons)
	## EDIT - network section NOT required, therefore I commented out the code.
	#####
	function checkResourcesSection() {
		global $_POST, $errorField;
		## check if the radio button was checked. if not highlight/flag the table
		if (! isset($_POST['resource'])) {
			$tmpErrorField = array ("resource" => "resource");
			$errorField = array_merge ($errorField,$tmpErrorField);
		} else {
#			if (! isset($_POST['network'])) {
#				$tmpErrorField = array ("network" => "network");
#				$errorField = array_merge ($errorField,$tmpErrorField);
#			} else {
#				## both fields are set, do nothing.
#			}
		} ## end if resource
	}
	
	
	#####
	## Function: setResourcesSection()
	## This function prints the error style if either is in the error field.
	## EDIT - network section NOT required, therefore I commented out the code.
	#####
	function setResourcesSection() {
		global $errorField;
#		if ( in_array("network", $errorField) || in_array("resource", $errorField) ) {
		if ( in_array("resource", $errorField) ) {
			print "class='error'";
		}
	}
	
	
	#####
	## Function: checkIfPI()
	## This function adds the required NON PI fields for the applicant to fill out,
	## else id does nothing.
	#####
	function checkIfPI() {
		## get access to POST and requiredfields variables.
		global $requiredFields;
		global $nonPIinputFields;
		global $_POST;
		## check if 'app_same' is set.
		if (isset($_POST['app_same'])) {
			## check the value of 'app_same', if the value is not 'yes'
			## add the remaining required fields.
			if ( ! preg_match("/yes/",$_POST['app_same']) ) {
				## add other required fields since applicant is not a PI.
				$requiredFields = array_merge($requiredFields, $nonPIinputFields);			
			} else {
				## The applicant is the PI, therefore the PI fields are the same
				## as the applicant name fields.
				if (isset($_POST['app_first_name'])) {
					$_POST['pi_first_name'] = $_POST['app_first_name'];
				}
				if (isset($_POST['app_last_name'])) {
					$_POST['pi_last_name'] = $_POST['app_last_name'];
				}
				if (isset($_POST['app_title'])) {
					$_POST['pi_title'] = $_POST['app_title'];
				}
				if (isset($_POST['app_spec_title'])) {
					$_POST['pi_spec_title'] = $_POST['app_spec_title'];
				}
				if (isset($_POST['app_email'])) {
					$_POST['pi_email'] = $_POST['app_email'];
				}
				if (isset($_POST['app_phone'])) {
					$_POST['pi_phone'] = $_POST['app_phone'];
				}
				if (isset($_POST['app_degree'])) {
					$_POST['pi_degree'] = $_POST['app_degree'];
				}
				if (isset($_POST['app_fax'])) {
					$_POST['pi_fax'] = $_POST['app_fax'];
				}	
			}
		} else {
			## default, add required fields.
			$requiredFields = array_merge($requiredFields, $nonPIinputFields);	
		}
	} ## End of checkIfPI function
	
	
	#####
	## Function: checkPersonnel()
	## This function checks the resources section of the form.
	## if the personnel radio button is selected as YES then the fields following
	## the section is required.
	#####
	function checkPersonnel() {
		## get access to POST and requiredfields variables.
		global $requiredFields, $personnelInputFields, $errorField;
		global $_POST;
		## check if 'personnel' is set.
		if (isset($_POST['personnel'])) {
			## check the value of 'app_same', if the value is not 'yes'
			## add the remaining required fields.
			if ( preg_match("/^yes$/",$_POST['personnel']) ) {
				## add other required fields since applicant is not a PI.
				$requiredFields = array_merge($requiredFields, $personnelInputFields);
				checkTitle("personnel_title_name","personnel_spec_title_name");			
			}
		} else {
			## if radio button is not set flag error
			$tmpErrorField = array ("personnel" => "personnel");
			$errorField = array_merge ($errorField,$tmpErrorField);
		}
	} ## End of checkPersonnel function
	
	
	#####
	## Function: setPersonnelSection()
	## This function prints the error style if either is in the error field.
	#####
	function setPersonnelSection() {
		global $errorField;
		if ( in_array("network", $errorField) || in_array("personnel", $errorField) ) {
			print "class='error'";
		}
	}


	#####
	## Function: checkVisitsSection()
	## This function checks the visits section of the form.
	## If the visits input sections are not valid, add to the error fields.
	#####
	function checkVisitsSection() {
		## get access to POST and requiredfields variables.
		global $errorField;
		global $_POST;
		## check if 'personnel' is set.
		if (isset($_POST['visits'])) {
			## check the value of 'app_same', if the value is not 'yes'
			## add the remaining required fields.
			if ( preg_match("/^\d+$/",$_POST['visits']) ) {
				## valid data, do nothing
			} else {
				## set flag error
				$tmpErrorField = array ("visits" => "visits");
				$errorField = array_merge ($errorField,$tmpErrorField);		
			}
		} else {
			## set flag error
			$tmpErrorField = array ("visits" => "visits");
			$errorField = array_merge ($errorField,$tmpErrorField);
		}
	} ## End of checkVisitsSection function


#######################################################################################
#### End - Check Sections #############################################################
#######################################################################################

?>
