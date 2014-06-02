<?php
	session_start();
	$sessionID = session_id();

	## get the required function modules and arrays used for this web form.
	require_once("content/validate.php");
	require_once("content/dataArrays.php");

	## get the conmmon variables
	require_once("content/common.php");

	## get current date in MM/DD/YYYY format
	$currentDate = date("m/d/Y");

	## initialize errorFields if data was set incorrectly.
	$errorField = array();

	#######################################################################################
	#### Start - Post Form check Section ##################################################
	#######################################################################################
	## check form if post var is not empty.
	if (isset($_POST['submit'])) {
		## check app title
		checkTitle("app_title","app_spec_title");
		## check pi title
		checkTitle("pi_title","pi_spec_title");
		## check country and state
		checkCountryAndState();
		## check project status
		checkProjectStatus();
		## check if 'app_same' value is set to 'NO'
		checkIfPI();
		## check personnel radio button, if set to yes, personnel fields are required.
		checkPersonnel();
		## check resources section.
		#RMME checkResourcesSection();
		## check the visits section
		checkVisitsSection();

		foreach ($requiredFields as $fieldName => $fieldRexp) {	
			## if the field input is NOT valid, mark the errorField array for flagging.
			if ( !checkInputfield($_POST, $fieldName, $fieldRexp) ) {
				## set field as an error (user needs to re-enter the data.)
				$tmpErrorField = array ($fieldName => $fieldName);
				$errorField = array_merge ($errorField,$tmpErrorField);
			} else {
				## valid input, save the data back into the validInput
			}
		}
		
		## if error field has no errors, all the data is verified.
		if ( count ($errorField) == 0 ) {
		
			## add to session variable
			foreach($_POST as $key=>$value){
				$_SESSION[$key]=$value;
			}
			## redirect to second part of web application.
			header("Location:" . $httpBase . $webPath . $webForm_submit . "?sessionID=" . $sessionID);
			exit;
		
		}	
	}
	#######################################################################################
	#### End - Post Form check Section ####################################################
	#######################################################################################
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NBCR Collaborator Application </title>
<link href="content/collaborator.css" media="screen" type="text/css" rel="stylesheet" rev="stylesheet" />
</head>

<body>
<!-- RM
<form action="application-UserInfo.php" method="post" name="Collaborator-Part1" target="_self" id="Collaborator-Part1">
-->
<form action="<?php print $webForm; ?>" method="post" name="Collaborator-Part1" target="_self" id="Collaborator-Part1">

  <h1>NBCR Collaborator Application</h1>

  <h5>Please complete the NBCR Collaborator application below with the details about your project. <br>
      Your application will be reviewd by the NBCR's Executive Committee.<br><br>
      Any field with a red asterisk <span class="star">*</span> denotes a required field. 
  </h5>

   <?php
   if (!empty($errorField)) {
       print "<span class='errormsg'>Some required fields are not set or not valid. Please re-enter the required fields denoted as *.</span>";
   }
   ?>
  
  <!-- main table -->
  <table width="800" border="0" cellpadding="1" cellspacing="2">

  <!-- User information section  -->
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr class="even" valign="top">
    <td colspan="2"> <h3>Section 1: User Information</h3> </td>
  </tr>

  <tr valign="top">
    <td width='50%'>
      <h5>Application</h5>
      <table border="0" cellpadding="1" cellspacing="2">
        <tr>
          <td width="25%" class="fieldDescription">First Name <span class="star">*</span></td>
          <td width="25%"><input name="app_first_name" type="text" class="<?php setInputStyle('app_first_name'); ?>" 
                     value="<?php setInputValue('app_first_name'); ?>" size="25" /></td>
          <td width="25%" class="fieldDescription">Last Name <span class="star">*</span></td>
          <td><input name="app_last_name" type="text" class="<?php setInputStyle('app_last_name'); ?>" 
                     id="app_last_name" value="<?php setInputValue('app_last_name'); ?>" size="25" /></td>
        </tr>

        <tr>
          <td class="fieldDescription">Email <span class="star">*</span></td>
          <td><input name="app_email" type="text" class="<?php setInputStyle('app_email'); ?>" id="app_email" 
                     value="<?php setInputValue('app_email'); ?>" size="25" maxlength="30" /></td>
          <td class="fieldDescription">Phone <span class="star">*</span></td>
          <td><input name="app_phone" type="text" class="<?php setInputStyle('app_phone'); ?>" id="app_phone" 
                     value="<?php setInputValue('app_phone'); ?>" size="25"/></td>
        </tr>

        <tr>
          <td class="fieldDescription">Fax <span class="star">*</span></td>
          <td><input name="app_fax" type="text" class="<?php setInputStyle('app_fax'); ?>" id="app_fax" 
                     value="<?php setInputValue('app_fax'); ?>" size="25" /></td>
          <td class="fieldDescription">Degree <span class="star">*</span></td>
          <td><select name="app_degree" class="<?php setSelectStyle('app_degree'); ?>" id="app_degree">
			    <?php printSelect($degreeArr, 'app_degree' ); ?> </select></td>
        </tr>
        <tr>
          <td class="fieldDescription">Title <span class="star">*</span></td>
          <td><select name="app_title" class="<?php setSelectStyle('app_title'); ?>" id="app_title">
                     <?php printSelect($titleArr, 'app_title' ); ?></select></td>
            <td class="fieldDescription">Other Title</td>
            <td><input name="app_spec_title" type="text" class="<?php setInputStyle('app_spec_title'); ?>" id="app_spec_title" 
                       value="<?php setInputValue('app_spec_title'); ?>" size="25"/></td>
        </tr>
      </table>
    </td>

    <td width="50%">
      <h5>Principal Investigator (please enter data if PI is <em>NOT</em> applicant <span class="star">*</span>)</h5>
      <table border="0" cellpadding="1" cellspacing="2">
        <tr>
          <td colspan="4" class="fieldDescription"><input type="checkbox" name="app_same" 
              value="yes" <?php setCheckboxInput("app_same","yes"); ?> />    Applicant is the PI. No additional information is required.</td>
        </tr>
        <tr>
          <td width="75" class="fieldDescription">First Name </td>
          <td><input name="pi_first_name" type="text" class="<?php setInputStyle('pi_first_name'); ?>" id="pi_first_name" 
                     value="<?php setInputValue('pi_first_name'); ?>" size="25" /></td>
          <td width="75" class="fieldDescription">Last Name </td>
          <td><input name="pi_last_name" type="text" class="<?php setInputStyle('pi_last_name'); ?>" id="pi_last_name" 
                     value="<?php setInputValue('pi_last_name'); ?>" size="25" maxlength="30" /></td>
        </tr>
        <tr>
          <td class="fieldDescription">Email</td>
          <td><input name="pi_email" type="text" class="<?php setInputStyle('pi_email'); ?>" id="pi_email" 
                     value="<?php setInputValue('pi_email'); ?>" size="25" maxlength="30" /></td>
          <td class="fieldDescription">Phone</td>
          <td><input name="pi_phone" type="text" class="<?php setInputStyle('pi_phone'); ?>" id="pi_phone" 
                     value="<?php setInputValue('pi_phone'); ?>" size="25" /></td>
        </tr>
        <tr>
          <td class="fieldDescription">Fax</td>
          <td><input name="pi_fax" type="text" class="<?php setInputStyle('pi_fax'); ?>" id="pi_fax" 
                     value="<?php setInputValue('pi_fax'); ?>" size="25" /></td>
          <td class="fieldDescription">Degree</td>
          <td><select name="pi_degree" class="<?php setSelectStyle('pi_degree'); ?>" id="pi_degree"> 
                      <?php printSelect($degreeArr, 'pi_degree' ); ?> </select></td>
        </tr>
        <tr>
          <td class="fieldDescription">Title</td>
          <td><select name="pi_title" class="<?php setSelectStyle('pi_title'); ?>" id="pi_title">
                     <?php printSelect($titleArr, 'pi_title' ); ?> </select></td>
          <td class="fieldDescription">Other Title</td>
          <td><input name="pi_spec_title" type="text" class="<?php setInputStyle('pi_spec_title'); ?>" id="pi_spec_title" 
                     value="<?php setInputValue('pi_spec_title'); ?>" size="25"/></td>
        </tr>
      </table>
    </td>
  </tr>

  <tr valign="top">
    <td>
    <h5>Institution Information</h5>
    <table border="0" cellspacing="2" cellpadding="1">
      <tr>
        <td width="125" class="fieldDescription">Institution <span class="star">*</span></td>
        <td><input name="institution" type="text" class="<?php setInputStyle('institution'); ?>" id="institution" 
                   value="<?php setInputValue('institution'); ?>" size="60" /></td>
      </tr>
      <tr>
        <td width="125" class="fieldDescription">Department <span class="star">*</span></td>
        <td><input name="department" type="text" class="<?php setInputStyle('department'); ?>" id="department" 
                   value="<?php setInputValue('department'); ?>" size="60" /></td>
      </tr>
      <tr>
        <td width="125" class="fieldDescription">Organization/Lab <span class="star">*</span></td>
        <td><input name="lab" type="text" class="<?php setInputStyle('lab'); ?>" id="lab" 
                   value="<?php setInputValue('lab'); ?>" size="60" /></td>
      </tr>
      <tr>
        <td width="125" class="fieldDescription">Major Research Area <span class="star">*</span></td>
        <td><input name="research_area" type="text" class="<?php setInputStyle('research_area'); ?>" id="research_area" 
                   value="<?php setInputValue('research_area'); ?>" size="60" /></td>
      </tr>
    </table>
    </td>

     <td>
     <h5>Institution Address</h5>
     <table border="0" cellpadding="1" cellspacing="2" >
       <tr>
         <td class="fieldDescription">Address Line 1 <span class="star">*</span></td>
         <td colspan="3"><input name="street1" type="text" class="<?php setInputStyle('street1'); ?>" id="street1" 
                                value="<?php setInputValue('street1'); ?>" size="60" /></td>
       </tr>
       <tr>
         <td class="fieldDescription">Address Line 2</td>
         <td colspan="3"><input name="street2" type="text" class="field" id="street2" 
                                value="<?php setInputValue('street2'); ?>" size="60" /></td>
       </tr>
       <tr>
         <td width="18%" class="fieldDescription">City <span class="star">*</span></td>
         <td width="12%"><input name="city" type="text" class="<?php setInputStyle('city'); ?>" id="city" 
                    value="<?php setInputValue('city'); ?>" size="25" /></td>
         <td width="10%" class="fieldDescription">State <span class="star">*</span></td>
         <td><select name="state" class="<?php setSelectStyle('state'); ?>" id="state"> <?php printSelect($statesArr, 'state' ); ?></select></td>
       </tr>
       <tr>
         <td class="fieldDescription">Province (non-US)</td>
         <td><input name="province" type="text" class="<?php setInputStyle('province'); ?>" id="province" 
                    value="<?php setInputValue('province'); ?>" size="25" /></td>
         <td class="fieldDescription">Postal code <span class="star">*</span></td>
         <td><input name="zip" type="text" class="<?php setInputStyle('zip'); ?>" id="zip" 
                    value="<?php setInputValue('zip'); ?>" size="19" /></td>
       </tr>
       <tr>
         <td class="fieldDescription">Country <span class="star">*</span></td>
         <td colspan="3"><select name="country" class="<?php setSelectStyle('country'); ?>" 
                                 id="country"><?php printSelect($countryArr, 'country' ); ?> </select> </td>
       </tr>
     </table>
     </td>
  </tr>

  <!-- Projct description section  -->
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr class="even">
    <td colspan="2"> <h3>Section 2: Project Description </h3> </td>
  </tr>

  <tr valign="top">
    <td>
      <h5>Project Status</h5>
      <table border="0" cellspacing="2" cellpadding="1" <?php setProjectSection(); ?> >
        <tr>
          <td width="125" class="fieldDescription">Select Project Status <span class="star">*</span></td>
          <td width="180" class="field">
            <input name="app_type" type="radio" id="app_type_continue" value="Continue" <?php setRadioInput("app_type","Continue"); ?> /> Continuing
            <input name="app_type" type="radio" id="app_type_new" value="New" <?php setRadioInput("app_type","New"); ?> /> New
          </td>
        </tr>
      </table>
    </td>

    <td>
      <h5>Title and Keywords</h5>
      <table border="0" cellspacing="2" cellpadding="1">
        <tr>
          <td width="100" class="fieldDescription">Title <span class="star">*</span></td>
          <td><input name="project_title" type="text" class="<?php setInputStyle('project_title'); ?>" id="project_title" size="60" 
                     value="<?php setInputValue('project_title'); ?>" /></td>
        </tr>
        <tr>
          <td class="fieldDescription">Keywords <span class="star">*</span></td>
          <td><input name="keywords" type="text" class="<?php setInputStyle('keywords'); ?>" id="keywords" size="60" 
                     value="<?php setInputValue('keywords'); ?>" /></td>
        </tr>
      </table>
    </td>
  </tr>

  <tr valign="top">
    <td >
      <h5>Abstract </h5>
      <table border="0" cellspacing="2" cellpadding="1">
        <tr>
          <td class="fieldDescription">
             Please provide a brief abstract (similar in content to the abstract for an NIH grant application).<br>
             Once your project is approved this abstract will be included as part of the NBCR annual report <br>
             to NIH and will be available on the publicly accessible CRISP NIH database. <span class="star">*</span>
          </td>
        </tr>
        <tr>
          <td><textarea name="abs_sum" cols="65" rows="10" class="<?php setInputStyle('abs_sum'); ?>" id="abs_sum">
                        <?php setInputValue('abs_sum'); ?></textarea> </td>
        </tr>
      </table>
    </td>

    <td >
      <h5>Summary </h5>
      <table border="0" cellspacing="2" cellpadding="1">
        <tr>
          <td class="fieldDescription">
             Please provide a more detailed description of the project you wish to carry out with NBCR resources.<br>
             This information will stay confidential. We will use both the non-confidential and confidential materials<br>
             in evaluating your application.  <span class="star">*</span>
          </td>
        </tr>
        <tr>
          <td><textarea name="full_sum" cols="65" rows="10" class="<?php setInputStyle('full_sum'); ?>" id="full_sum">
                        <?php setInputValue('full_sum'); ?></textarea> </td>
        </tr>
      </table>
    </td>

  </tr>

  <!-- Resource request section -->
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr class="even">
    <td colspan="2"> <h3>Section 3: Resource Request</h3> </td>
  </tr>

  <tr valign="top">
    <td>
       <h5>Computational Resources </h5>
       <table border="0" cellspacing="2" cellpadding="1" <?php setResourcesSection(); ?> >
         <tr>
           <td class="fieldDescription">Software <span class="star">*</span></td>
           <td><input name="resource_software" type="text" class="<?php setInputStyle('resource_software'); ?>" 
                      value="<?php setInputValue('resource_software'); ?>" size="60" /></td>
         </tr>
         <tr>
           <td class="fieldDescription">Cluster / web server <span class="star">*</span></td>
           <td class="field"><input name="resource_computer" type="text" class="<?php setInputStyle('resource_computer'); ?>" 
               value="<?php setInputValue('resource_computer'); ?>" size="60" /></td>
         </tr>
       </table>

       <h5>Visits</h5>
       <table border="0" cellspacing="2" cellpadding="1">
         <tr>
           <td width="250" class="fieldDescription">How many times do you plan to visit NBCR? <span class="star">*</span></td>
           <td class="field">
             <input name="visits" type="text" class="<?php setInputStyle('visits'); ?>" id="visits" size="3" 
                    value="<?php setInputValue('visits'); ?>" /> Visits per 
                    <select name="visits_per" class="<?php setSelectStyle('visits_per'); ?>" 
                            id="visits_per"> <?php printSelect($visitsArr, 'visits_per' ); ?>
                    </select>
           </td>
         </tr>
       </table>
    </td>

    <td>
      <h5>Project Personnel</h5>
      <table border="0" cellspacing="2" cellpadding="1" <?php setPersonnelSection(); ?>>
        <tr>
          <td colspan="2" class="fieldDescription">Will you provide personnel? <span class="star">*</span></td>
          <td colspan="2" class="field">
            Yes <input type="radio" name="personnel" id="personnel_yes" value="yes" <?php setRadioInput("personnel","yes"); ?> />
            No <input name="personnel" id="personnel_no" type="radio" value="no" <?php setRadioInput("personnel","no"); ?> />
          </td>
        </tr>
        <tr>
          <td class="fieldDescription">First Name</td>
          <td><input name="personnel_first_name" type="text" class="<?php setInputStyle('personnel_first_name'); ?>" 
                     id="personnel_first_name" value="<?php setInputValue('personnel_first_name'); ?>" size="30" /></td>
          <td class="fieldDescription">Last Name</td>
          <td><input name="personnel_last_name" type="text" class="<?php setInputStyle('personnel_last_name'); ?>" 
                     id="personnel_last_name" value="<?php setInputValue('personnel_last_name'); ?>" size="30" /></td>
        </tr>
        <tr>
          <td class="fieldDescription">Title</td>
          <td><select name="personnel_title_name" class="<?php setSelectStyle('personnel_title_name'); ?>" 
                      id="personnel_title_name"> <?php printSelect($titleArr, 'personnel_title_name' ); ?> </select></td>
          <td class="fieldDescription">Other Title</td>
          <td><input name="personnel_spec_title_name" type="text" class="<?php setInputStyle('personnel_spec_title_name'); ?>" 
                     id="personnel_spec_title_name" value="<?php setInputValue('personnel_spec_title_name'); ?>" size="30" /></td>
        </tr>
        <tr>
          <td class="fieldDescription">Email</td>
          <td><input name="personnel_email_name" type="text" class="<?php setInputStyle('personnel_email_name'); ?>" 
                     id="personnel_email_name" value="<?php setInputValue('personnel_email_name'); ?>" size="30" /></td>
          <td class="fieldDescription">Degree</td>
          <td><select name="personnel_degree" class="<?php setSelectStyle('personnel_degree'); ?>" 
                      id="personnel_degree"> <?php printSelect($degreeArr, 'personnel_degree' ); ?> </select></td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Section Funding -->
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr class="even">
    <td colspan="2"> <h3>Section 4: Funding</h3> </td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>

  <tr>
    <td colspan="2">
     <table border="0" cellspacing="2" cellpadding="1">
      <tr>
        <td colspan="7" class="fieldDescription">Peer-reviewed funding is required for project or resource usage 
            application approval.<strong> A minimum of one funding source is required.<span class="star">*</span></strong> <br />
            If more than one funding source is available, ALL FIELDS are required to be counted as a complete funding source.</td>
      </tr>
      <tr>
        <td width="25" align="center" class="fieldDescription">&nbsp;</td>
        <td align="center" class="fieldDescription">Source</td>
        <td align="center" class="fieldDescription">Grant Number</td>
        <td align="center" class="fieldDescription">PI First Name</td>
        <td align="center" class="fieldDescription">PI Last Name</td>
        <td align="center" class="fieldDescription">Grant Title</td>
        <td align="center" class="fieldDescription">Funding Period</td>
      </tr>
      <tr>
        <td width="25" align="center" class="fieldDescription">1<span class="star">*</span></td>
        <td><input size="35" name="source1" type="text" class="<?php setInputStyle('source1'); ?>" id="source1" 
                   value="<?php setInputValue('source1'); ?>"/></td>
        <td><input size="15" name="grant1" type="text" class="<?php setInputStyle('grant1'); ?>" id="grant1" 
                   value="<?php setInputValue('grant1'); ?>" /></td>
        <td><input size="20" name="pi_first_name1" type="text" class="<?php setInputStyle('pi_first_name1'); ?>" id="pi_first_name1" 
                   value="<?php setInputValue('pi_first_name1'); ?>" /></td>
        <td><input size="25" name="pi_last_name1" type="text" class="<?php setInputStyle('pi_last_name1'); ?>" id="pi_last_name1" 
                   value="<?php setInputValue('pi_last_name1'); ?>"/></td>
        <td><input size="35" name="title1" type="text" class="<?php setInputStyle('title1'); ?>" id="title1" 
                   value="<?php setInputValue('title1'); ?>" /></td>
        <td><input size="35" name="period1" type="text" class="<?php setInputStyle('period1'); ?>" id="period1" 
                   value="<?php setInputValue('period1'); ?>" /></td>
      </tr>
      <tr>
        <td width="25" align="center" class="fieldDescription">2</td>
        <td><input size="35" name="source2" type="text" class="field" id="source2" value="<?php setInputValue('source2'); ?>" /></td>
        <td><input size="15" name="grant2" type="text" class="field" id="grant2" value="<?php setInputValue('grant2'); ?>" /></td>
        <td><input size="20" name="pi_first_name2" type="text" class="field" id="pi_first_name2" 
                   value="<?php setInputValue('pi_first_name2'); ?>" /></td>
        <td><input size="25" name="pi_last_name2" type="text" class="field" id="pi_last_name2" 
                   value="<?php setInputValue('pi_last_name2'); ?>" /></td>
        <td><input size="35" name="title2" type="text" class="field" id="title2" value="<?php setInputValue('title2'); ?>" /></td>
        <td><input size="35" name="period2" type="text" class="field" id="period2" value="<?php setInputValue('period2'); ?>" /></td>
      </tr>
      <tr>
        <td width="25" align="center" class="fieldDescription">3</td>
        <td><input size="35" name="source3" type="text" class="field" id="source3" value="<?php setInputValue('source3'); ?>" /></td>
        <td><input size="15" name="grant3" type="text" class="field" id="grant3" value="<?php setInputValue('grant3'); ?>" /></td>
        <td><input size="20" name="pi_first_name3" type="text" class="field" id="pi_first_name3" 
                   value="<?php setInputValue('pi_first_name3'); ?>" /></td>
        <td><input size="25" name="pi_last_name3" type="text" class="field" id="pi_last_name3" 
                   value="<?php setInputValue('pi_last_name3'); ?>" /></td>
        <td><input size="35" name="title3" type="text" class="field" id="title3" value="<?php setInputValue('title3'); ?>" /></td>
        <td><input size="35" name="period3" type="text" class="field" id="period3" value="<?php setInputValue('period3'); ?>" /></td>
      </tr>
      <tr>
        <td width="25" align="center" class="fieldDescription">4</td>
        <td><input size="35" name="source4" type="text" class="field" id="source4" value="<?php setInputValue('source4'); ?>" /></td>
        <td><input size="15" name="grant4" type="text" class="field" id="grant4" value="<?php setInputValue('grant4'); ?>" /></td>
        <td><input size="20" name="pi_first_name4" type="text" class="field" id="pi_first_name4" 
                   value="<?php setInputValue('pi_first_name4'); ?>" /></td>
        <td><input size="25" name="pi_last_name4" type="text" class="field" id="pi_last_name4" 
                   value="<?php setInputValue('pi_last_name4'); ?>" /></td>
        <td><input size="35" name="title4" type="text" class="field" id="title4" value="<?php setInputValue('title4'); ?>" /></td>
        <td><input size="35" name="period4" type="text" class="field" id="period4" value="<?php setInputValue('period4'); ?>" /></td>
      </tr>
      <tr>
        <td width="25" align="center" class="fieldDescription">5</td>
        <td><input size="35" name="source5" type="text" class="field" id="source5" value="<?php setInputValue('source5'); ?>" /></td>
        <td><input size="15" name="grant5" type="text" class="field" id="grant5" value="<?php setInputValue('grant5'); ?>" /></td>
        <td><input size="20" name="pi_first_name5" type="text" class="field" id="pi_first_name5" 
                   value="<?php setInputValue('pi_first_name5'); ?>" /></td>
        <td><input size="25" name="pi_last_name5" type="text" class="field" id="pi_last_name5" 
                   value="<?php setInputValue('pi_last_name5'); ?>" /></td>
        <td><input size="35" name="title5" type="text" class="field" id="title5" value="<?php setInputValue('title5'); ?>" /></td>
        <td><input size="35" name="period5" type="text" class="field" id="period5" value="<?php setInputValue('period5'); ?>" /></td>
      </tr>
    </table>
   </td>
  </tr>

  <!-- Section references -->
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr class="even">
    <td colspan="2"> <h3>Section 5: References</h3> </td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>

  <tr>
    <td colspan="2">
      <table border="0" cellspacing="2" cellpadding="1">
      <tr>
        <td colspan="4" class="fieldDescription">Please provide citations for three<span class="star">*</span> to five relevant 
          publications most applicable to your proposed NCMIR project/resource request.<br />
          If only 1 to 2 publications are available, please enter &quot;NA&quot; on the remaining required fields.</td>
      </tr>
      <tr>
        <td width="25" align="center" class="fieldDescription subtitle subtitle">1<span class="star">*</span></td>
        <td><textarea name="publication1" cols="62" rows="4" class="<?php setInputStyle('publication1'); ?>" 
                      id="publication1"><?php setInputValue('publication1'); ?></textarea></td>
        <td width="25" align="center" class="fieldDescription subtitle subtitle">4</td>
        <td><textarea name="publication4" cols="62" rows="4" class="field" 
                      id="publication4"><?php setInputValue('publication4'); ?></textarea></td>
      </tr>

      <tr>
        <td width="25" align="center" class="fieldDescription subtitle subtitle">2<span class="star">*</span></td>
        <td><textarea name="publication2" cols="62" rows="4" class="<?php setInputStyle('publication2'); ?>" 
                      id="publication2"><?php setInputValue('publication2'); ?></textarea></td>
        <td width="25" align="center" class="fieldDescription subtitle subtitle">5</td>
        <td><textarea name="publication5" cols="62" rows="4" class="field" 
                      id="publication5"><?php setInputValue('publication5'); ?></textarea></td>
      </tr>
      <tr>
        <td width="25" align="center" class="fieldDescription subtitle subtitle">3<span class="star">*</span></td>
        <td><textarea name="publication3" cols="62" rows="4" class="<?php setInputStyle('publication3'); ?>" 
                      id="publication3"><?php setInputValue('publication3'); ?></textarea></td>
        <td colspan="2">&nbsp;</td>
      </tr>
      </table>

    </td>
  </tr>
</table>

  <table  border="0" cellspacing="2" cellpadding="1">
    <tr>
      <td><h5>Please verify that all required fields are filled out and submit your application: &nbsp;&nbsp; </h5> </td>
      <td><input name="submit" type="submit" id="submit" value="Submit application" /></td>
      <td><input type="hidden" name="date" value="<?php print $currentDate; ?>" />
        <input type="hidden" name="status_date" value="<?php print $currentDate; ?>" />
        <input type="hidden" name="sessionident" value="<?php print $sessionID; ?>" /></td>
    </tr>
  </table>

</form>
</body>
</html>
