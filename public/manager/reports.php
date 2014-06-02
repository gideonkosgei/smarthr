<?php require_once("../../includes/initialize.php");?>

<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}

$staff=Staff::find_by_staff_id($session->user_id);
$staff_of_this_dept=Staff::find_staff_by_department($staff->department_id);

?>




<?php include_layout_template('header'); ?>
<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="applications.php" class="">Applications</a></li><li><a href="mails.php" class="">Mails</a></li><li><a href="reports.php" class="active">Reports</a></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="applications.php" class="">Applications</a></li><li><a href="mails.php" class="">Mails</a></li><li><a href="reports.php" class="active">Reports</a></li></ul>
                
        </div>
</div></div>
                                                <div class="art-layout-cell art-content"><article class="art-post art-article">
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">REPORTS GENERATION SECTION</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix">
				
								<!------------report 1---------->
				<fieldset class="fieldset"><br/>
				<legend>Applications Reports</legend>
				<form action="report_view.php" method="post">
				
                 Date From<input type="date" name="date_from"/>Date To<input type="date" name="date_to"/>
				 <input type="hidden" name="department" value="<?php echo $staff->department_id;?>">
				<input type="submit" value="generate report" name="report1">
				</form>

				</fieldset>
				<!-- ------------------   report 2------------------------------------------               -->
				<fieldset class="fieldset">
					<legend>leave Application History</legend>
				<br/>
				
				<form action="report_view.php" method="post">
			
				<b>Select Staff Name:</b><select name="staff_id">
				
				<?php foreach($staff_of_this_dept as $staff):?>
				<option  value="<?php echo $staff->staff_id;?>"><?php echo $staff->first_name." ".$staff->last_name;?></option>
				<?php endforeach; ?>
				
				</select><input type="submit" value="generate report" name="report2">

				</fieldset>
				
				<fieldset class="fieldset">
				<legend>staff on leave</legend>
				<br/>
				<form action="report_view.php" method="post">

				<input type="submit" value="staff on leave report" name="report3">
				</form>

				</fieldset>
				
				
				
				</div>


</article></div>
                    </div>
                </div>
            </div><?php include_layout_template('footer'); ?>