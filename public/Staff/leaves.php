<?php require_once("../../includes/initialize.php");?>

<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');

}
$today=Date("Y-m-d");

$stf=Staff::find_by_staff_id($session->user_id);
$last_application=Applications::find_my_last_application($session->user_id);

	if(isset($_POST['apply'])){
	$date_from=trim($_POST['start_date']);
	$date_to=trim($_POST['end_date']);
	$day_month=date('d-F',strtotime($date_from));
	$day_month1=date('d-F',strtotime($date_to));
	$date_from_isholiday=Holidays::isholiday($day_month);
	$date_to_isholiday=Holidays::isholiday($day_month1);	
	$app->leave_id=trim($_POST['leave_id']);
	$date_from=$app->date_from=trim($_POST['start_date']);
	$day_to=$app->date_to=trim($_POST['end_date']);
	$app->staff_id=$session->user_id;	
	$app->status="pending";
	$app->application_date=Date("Y-m-d");
	$app->department_id=$stf->department_id;
	$lv=Leave::find_by_leave_id($_POST['leave_id']);	

	$dayOfTheWeek_start=dayOfTheWeek($_POST['start_date']);
	$dayOfTheWeek_ends=dayOfTheWeek($_POST['end_date']);
	
	
	
	
	
	
	
	
	$sQL="SELECT * FROM `applications`WHERE staff_id=$session->user_id ORDER BY `application_id` DESC LIMIT 1";
	$app_get_row=$app->get_row($sQL);
	
	
	$days_on_leave=Holidays::days_on_leave_Weekends_and_Holidays_removed($_POST['start_date'],$_POST['end_date']);
		

if($app_get_row){
$status = $app_get_row->status;
$today=date('Y-m-d');
$from=$app_get_row->date_from;
	if($status=="pending"){
		$message_type="error";
		$message="You Already Have Pending Application. Wait For The Application To Be Processed Or Cancel The Application Then Proceed";
		}
		else if($status=="granted" && $from > $today){
		$message="Double Application Is Not allowed";
		$message_type="error";
		}
		else if($dayOfTheWeek_start=="saturday" || $dayOfTheWeek_start=="sunday"){
		$message="You cannot start Leave Of On a Weekend. Please Choose A Working Day";
		$message_type="error";
		}
		else if($dayOfTheWeek_ends=="saturday" || $dayOfTheWeek_ends=="sunday"){
		$message="You cannot End Leave Of On a Weekend. Please Choose A Working Day";
		$message_type="error";
		}
		else if($_POST['start_date'] > $_POST['end_date']){
		$message="Invalid Date Entries.You Cannot End Leave Before You Start";
		$message_type="error";
		}
		else if($date_from_isholiday){
		$message="You cannot Start Your Leave On A Holiday.The Holiday Will Be ".$date_from_isholiday->holiday_name;
		$message_type="error";
		}
		else if($date_to_isholiday){
		$message="You cannot End Your Leave On A Holiday.The Holiday Will Be ".$date_to_isholiday->holiday_name;
		$message_type="error";
		}

		else if($days_on_leave>$lv->max_days){
		$message="You have Exceeded The Maximum Days For This Type Of Leave";
		$message_type="error";
		}
		else if($lv->qualification!="ALL" && ($stf->contract_type=="permanent" && $lv->qualification=="TEMPORARY")){
		$message="This Leave is For only Temporary Staff And You Are Not";
		$message_type="error";
		}
		else if($lv->qualification!="ALL" && ($stf->contract_type=="temporary" && $lv->qualification=="PERMANENT")){
		$message="This Leave is For only Permanent Staff And You Are Not";
		$message_type="error";
		}
		else if($lv->applicability!="ALL" && ($stf->gender=="male" && $lv->applicability=="FEMALE") ){
		$message="This Leave is Only Applicable To Female Staff";
		$message_type="error";
		}
		else if($lv->applicability!="ALL" && ($stf->gender=="female" && $lv->applicability=="MALE")){
		$message="This Leave is Only Applicable To Male Staff";
		$message_type="error";
		}
		else if($last_application->date_to>$today)
		{
		$message="you are suppossed to be On Leave. Process failed";
		$message_type="error";
		}
		else if($stf->balance<$days_on_leave && $lv->leave_type=="ANNUAL"){
		$message="Your Leave Account Is ";
		$message.=$stf->balance;
		$message.=" Days And You Have Applied for ";
		$message.=$days_on_leave;
		$message.=" days. The deficit is ";
		$message.=$days_on_leave-$stf->balance;
		$message.=" Days";
		$message_type="error";

		}
		else{
		
		$there_is_manager=Staff::find_department_manager($stf->department_id);
		if($there_is_manager){
			if($app->save()){
			$message="Application successful";
			$message_type="success";		
			
			}
			else{
			$message="not success";
			}
			}
			else{
			$message_type="error";
			$message="The Department Has No Head And Therefore No sanctioning Authority. Process failed";
			
			}

		}
	}else{
	
	
	
	if($dayOfTheWeek_start=="saturday" || $dayOfTheWeek_start=="sunday"){
		$message="You cannot start Leave Of On a Weekend. Please Choose A Working Day";
		$message_type="error";
		}
		else if($dayOfTheWeek_ends=="saturday" || $dayOfTheWeek_ends=="sunday"){
		$message="You cannot End Leave Of On a Weekend. Please Choose A Working Day";
		$message_type="error";
		}
		else if($today>$_POST['start_date'] || $today>$_POST['end_date']){
		$message="Invalid Date Entries.You Cannot Apply Leave On A Past Date";
		$message_type="error";
		}
		else if($_POST['start_date'] > $_POST['end_date']){
		$message="Invalid Date Entries.You Cannot End Leave Before You Start";
		$message_type="error";
		}
		else if($date_from_isholiday){
		$message="You cannot Start Your Leave On A Holiday.The Holiday Will Be ".$date_from_isholiday->holiday_name;
		$message_type="error";
		}
		else if($date_to_isholiday){
		$message="You cannot End Your Leave On A Holiday.The Holiday Will Be ".$date_to_isholiday->holiday_name;
		$message_type="error";
		}

		else if($days_on_leave>$lv->max_days){
		$message="You have Exceeded The Maximum Days For This Type Of Leave";
		$message_type="error";
		}
		
		else if($stf->balance<$days_on_leave && $lv->leave_type=="ANNUAL"){
		$message="Your Leave Account Is ";
		$message.=$stf->balance;
		$message.=" Days And You Have Applied for ";
		$message.=$days_on_leave;
		$message.=" days. The deficit is ";
		$message.=$days_on_leave-$stf->balance;
		$message.=" Days";
		$message_type="error";

		}
		else{
			if($app->save()){
			$message="Application successful";
			$message_type="success";
			
			
			$not=new Notifications();
			$is_hr=Staff::find_by_staff_id($session->user_id);
			    $man=Staff::manager_department($stf->department_id);	          
			    $not->sender=$session->user_id;
				
               if($is_hr->adm=="hr"){
			   $not->receiver=$session->user_id;
			   }
                 else{				
				$not->receiver=$man->staff_id;
				}
				$not->subject="Leave Application Request";
				$not->message="I Have Sent A Leave Application For Your Approval";
				$not->status="inbox";
				$not->save();
			
			}
			else{
			$message="not success";
			}

		}
	
	
	}
}

$leaves=Leave::find_all();//select all for display

?>












<?php include_layout_template('header'); ?>
<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="leaves.php" class="active">Leaves</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="settings.php">Settings</a></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="leaves.php" class="active">Leaves</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="settings.php">Settings</a></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
				<?php    
				
				if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}
				?>
				
				
				
				
				
				
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Apply For Leave Here</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				<div class="details">
				<fieldset>
				<legend>Details</legend>
				<table>
				<tr><th>#</th><th><u>NAME</u></th><th><u>LEAVE TYPE</u></th><th><u>MAX</u></th><th><u>QUALIFICATION</u></th><th><u>APPLICABILITY</u></th><th><u>START DATE</u></th><th><u>END DATE</u></th><th><u>ACTION</u></th></tr>
				<?php $no=1; foreach($leaves as $leave): 
				
				if(($stf->contract_type==$leave->qualification or $leave->qualification=="all" ) AND ($stf->gender==$leave->applicability or $leave->applicability=="all")){
				
				?>
				
				<tr><td><form method="post" action="leaves.php"><?php echo $no;?></td><td><?php echo $leave->leave_name;?></td><td><?php echo $leave->leave_type;?></td><td><?php echo $leave->max_days;?></td><td><?php echo $leave->qualification;?></td><td><?php echo $leave->applicability;?></td><td><input type="date" name="start_date" min="<?php echo $today;?>" required /></td><td><input type="date" name="end_date" min="<?php echo $today;?>" required/></td><td><input type="submit" value="apply" name="apply"><input type="hidden"  name="leave_id"value="<?php echo $leave->leave_id?>"></form></td></tr>
				 
				 <?php $no++; } else{} endforeach; ?>
				</table>
				</fieldset>
				</div>
				
				
				
				
				
				</p></div>

				</p></div>


</article></div>
                    </div>
               
            </div><?php include_layout_template('footer'); ?>