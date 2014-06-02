<?php require_once("../../includes/initialize.php");?>
<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}


if(isset($_POST['grant']))
{

$apps=Applications::find_by_application_id($_POST['app_id']);
	$apps->status="granted";
	if($apps->save()){
	$message_type="success";
	$message="Leave Granted Successfully";
	
	$not=new Notifications();
	  			             
		$not->sender=$session->user_id;				
		$not->receiver=$_POST['staff_id'];
		$not->subject="Leave Application Granted";
		$not->message="Your Leave Application Has Been Accepted.";
		$not->status="inbox";
		$not->save();	
	}
	else{
	 $message="";
	}
}
if(isset($_POST['reject'])){
$apps=Applications::find_by_application_id($_POST['app_id']);
		$apps->status="rejected";
	if($apps->save()){
	$message_type="success";
	$message="Leave Rejected";
	
	$not=new Notifications();
	  		             
		$not->sender=$session->user_id;				
		$not->receiver=$_POST['staff_id'];
		$not->subject="Leave Application Rejected";
		$not->message="Your Leave Application Has Rejected";
		$not->status="inbox";
		$not->save();	
	}
	else{
	 $message="";
	}
}
else{
}
$applications=Applications::find_all();//select all applications

?>
<?php include_layout_template('header'); ?>



<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="">Managers</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="holidays.php" class="">Holidays</a></li><li><a href="applications.php" class="active">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="">Managers</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="holidays.php" class="">Holidays</a></li><li><a href="applications.php" class="active">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
						<?php if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Applications</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				<div class="details">
				<fieldset>
				<legend>Details</legend>
				<table>
				<tr><th>#</th><th><u>STAFF NAME</u></th><th><u>DEPARTMENT</u></th><th><u>LEAVE</u></th><th><u>START</u></th><th><u>END</u></th><th><u>DAYS</u></th><th><u>STATUS</u></th><th><u>ACTION</u></th></tr>
			  <?php $no=1; foreach($applications as $app): ?>
				<tr> <form method="post" action="applications.php"> <input type="hidden" name="app_id" value="<?php echo $app->application_id; ?>"/><input type="hidden" name="staff_id" value="<?php echo $app->staff_id; ?>"/>
				<td><?php echo $no;?></td>
				<td><?php $stf=Staff::find_by_staff_id($app->staff_id);echo $stf->first_name." ".$stf->last_name;?></td>
				
				<td><?php $dept=Department::find_by_department_id($stf->department_id);echo $dept->department_name;?></td>
				<td><?php $l=Leave::find_by_leave_id($app->leave_id); echo $l->leave_name;?></td>
				<td><?php echo $app->date_from;?></td>
				<td><?php echo $app->date_from;?></td><td><?php echo $d =$days_on_leave=Holidays::days_on_leave_Weekends_and_Holidays_removed($app->date_from,$app->date_to);?></td>
				<td>
				
				<?php 
				
				if($app->status=="cancelled" && $app->manager_status==null){
				echo $app->status." By User";
				}
				else if($app->status=="pending" && $app->manager_status==null){
				echo "Waiting For Approval";
				}
				else if(($app->status=="rejected"|| $app->status=="accepted")&& $app->manager_status=="granted"){
				echo $app->status." By HR";
				}
				else{
				echo $app->manager_status." By Manager";
				}
				   ?>
				
				</td><td>
				
				<?php
				//$app->status=="cancelled" || ($app->status=="pending" && ($app->manager_status==null||$app->manager_status=="") ) || $app->hr_status!=null){ }
				//if($app->status=="cancelled" || $app->manager_status==null || $app->manager_status==""|| $app->manager_status=="rejected"){ }
				if($app->manager_status=="granted" && $app->status=="pending"){
				?><input type="submit" value="Grant" name="grant"><input type="submit" value="Reject" name="reject">
				<?php }?> 
				
				</td></form></tr>
				<?php $no++; endforeach;?>
				</table>
				</fieldset>
				</div>
				

				
				
				
				</p></div>


</article></div>
                    </div>
                </div>
            </div>
			
			
			<?php include_layout_template('footer'); ?>