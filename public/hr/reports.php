<?php require_once("../../includes/initialize.php");?>
<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}

$department=Department::find_all();
$departments=Department::find_all();
$department1=Department::find_all();
$staff=Staff::find_all();




?>
<?php include_layout_template('header'); ?>



<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="">Managers</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="holidays.php" class="">Holidays</a></li><li><a href="applications.php" class="">Applications</a></li><li><a href="mails.php" class="">Mails</a></li><li><a href="reports.php" class="active">Reports</a><ul class="active"></ul></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul> 
    <ul class="art-hmenu" style="float:right;">
	<li> <span style="text-align:justify;">
	
	<p><a href="logout.php"><img src="../images/logout.png" alt="logout"></a></p>
	</span>	</li>	</ul>
	
	</nav>
<div class="art-layout-wrapper">
                <div class="art-content-layout">
                    <div class="art-content-layout-row">
                        <div class="art-layout-cell art-sidebar1"><div class="art-vmenublock clearfix">
        <div class="art-vmenublockheader">
            <h3 class="t">MENU</h3>
        </div>
        <div class="art-vmenublockcontent">
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="">Managers</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="holidays.php" class="">Holidays</a></li><li><a href="applications.php" class="">Applications</a></li><li><a href="mails.php" class="">Mails</a></li><li><a href="reports.php" class="active">Reports</a><ul class="active"></ul></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">REPORTS GENERATION SECTION</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix">
				<!------------report 1---------->
				<fieldset class="fieldset">
				<legend>Applications Reports</legend>
				<form action="report_view.php" method="post">
				
				<b>Department:  </b>
				<select name="department">
				<option value="all">all</option>
				<?php foreach($department as $department):?>
				<option value="<?php  echo $department->department_id;?>"><?php echo $department->department_name;?></option>
				<?php endforeach; ?>
				</select> Date From<input type="date" name="date_from"/>Date To<input type="date" name="date_to"/>
				<input type="submit" value="generate report" name="report1">
				</form>
				</fieldset>
				<!-- ------------------   report 2------------------------------------------               -->
				<fieldset class="fieldset">
				<legend>leave Application History</legend>
				<form action="report_view.php" method="post">
				
				<b>Select Staff Name:</b><select name="staff_id">
				
				<?php foreach($staff as $staff):?>
				<option  value="<?php echo $staff->staff_id;?>"><?php echo $staff->first_name." ".$staff->last_name;?></option>
				<?php endforeach; ?>
				
				</select><input type="submit" value="generate report" name="report2">
				</fieldset>
				
				

				<!-- report 5-------->
				<fieldset class="fieldset">
				<legend>staff Reports</legend>
				<form method="post" action="report_view.php">
				
				<b>Select Department:</b><select name="department">
				<option value="all">All</option>
				
				<?php foreach($departments as $department):?>
				<option value="<?php echo $department->department_id;?>"><?php echo $department->department_name;?></option>
				<?php endforeach; ?>				
			    <input type="submit" value="generate report" name="report5">
				</form>
				</fieldset>
				
				
				
				
				</div>


</article></div>
                    </div>
                </div>
            </div><?php include_layout_template('footer'); ?>