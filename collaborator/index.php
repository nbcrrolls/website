<?php 
    if (isset($_GET['emptyID']) && $_GET['emptyID'] === '1') {
        $errorMessage = "<span class='errormsg'>Please provide application ID</span>";
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>NBCR Collaborators application administration </title>
<link href="content/collaborator.css" media="screen" rel="stylesheet" rev="stylesheet" type="text/css" />
</head>

<body>
<h1>NBCR Collaborators application administration </h1>

<center>
<?php isset($errorMessage) ? print "<p>" . $errorMessage . "</p>" : print "";?>
<table width="750" border="0" cellpadding="2" cellspacing="2" class="outline">
  <tr>
    <td class="header">Viewing</td>
  </tr>
  <tr>
    <td>View all applications <a href="admin/view-applications.php"><img src="content/images/green-arrow.png"  valign="bottom" /></a></td>
  </tr>

  <tr>
    <td>View applications by status: 
        <a class="status" role="button" href="admin/view-applications.php?status=New" target="_blank">New</a>
        <a class="status" role="button" href="admin/view-applications.php?status=Approved" target="_blank">Approved</a>
        <a class="status" role="button" href="admin/view-applications.php?status=Active" target="_blank">Active</a>
        <a class="status" role="button" href="admin/view-applications.php?status=Inactive" target="_blank">Inactive</a>
        <a class="status" role="button" href="admin/view-applications.php?status=Rejected" target="_blank">Rejected</a>
        <a class="status" role="button" href="admin/view-applications.php?status=Pending" target="_blank">Pending</a>
        <a class="status" role="button" href="admin/view-applications.php?status=Completed" target="_blank">Completed</a>
<!--
These work in Chrome and Safari but fail in Firefox 
        <button class="status" onclick="#0"><a href="admin/view-applications.php?status=New" target="_blank">New</a></button>
        <button class="status" onclick="#0"><a href="admin/view-applications.php?status=Approved" target="_blank">Approved</a></button>
        <button class="status" onclick="#0"><a href="admin/view-applications.php?status=Active" target="_blank">Active</a></button>
        <button class="status" onclick="#0"><a href="admin/view-applications.php?status=Inactive" target="_blank">Inactive</a></button>
        <button class="status" onclick="#0"><a href="admin/view-applications.php?status=Rejected" target="_blank">Rejected</a></button>
        <button class="status" onclick="#0"><a href="admin/view-applications.php?status=Pending" target="_blank">Pending</a></button>
        <button class="status" onclick="#0"><a href="admin/view-applications.php?status=Completed" target="_blank">Completed</a></button>
-->
    </td>
  </tr>

  <tr>
    <td>
      <form action="admin/view-applicant.php" method="get" name="view-applicant-by-id" target="_blank" id="view-applicant-by-id">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td>View full application (enter application ID <span class="star">*</span>):</td>
            <td><input name="id" type="text" id="id" size="5" /></td>
            <td><input name="view-applicant" type="submit" id="view-applicant" value="View"/></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>

<!-- Updates -->
  <tr>
    <td class="header">Updating</td>
  </tr>

  <tr>
    <td>Update new application status 
        <a href="admin/update-application-status.php?status=New"><img src="content/images/green-arrow.png" valign="bottom" /></a>
    </td>
  </tr>

  <tr>
    <td>
        <form action="admin/update-application-summary.php" method="get" name="update-summary-by-id" 
              target="_blank" id="update-application-summary-by-id">
          <table border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td>Update abstract or summary (enter application ID <span class="star">*</span>):</td>
              <td><input name="id" type="text" id="id" size="5" /></td>
              <td><input name="update-summary" type="submit" id="update-summary" value="Update"/></td>
            </tr>
          </table>
	</form>
    </td>
  </tr>

  <tr>
    <td class="header">Application Auditing </td>
  </tr>

  <tr>
    <td>
      <p><a href="admin/audit-db.php">Applications database administration</a> <img src="content/images/lock.png" width="15" valign="center"/></p>
    <br/>
    </td>
  </tr>
</table>
</center>

<p>&nbsp;</p>

</body>
</html>
