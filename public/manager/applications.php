<?php require_once("../../includes/initialize.php");?>

<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}

$me=Staff::find_by_staff_id($session->user_id);

$hr=Staff::find_hr();


$all=Staff::find_by_staff_id($session->user_id);



if(isset($_POST['grant']))
{
$apps=Applications::find_by_application_id($_POST['app_id']);
	$apps->manager_status="granted";
	if($apps->save()){
	$message_type="success";
	$message="Application Accepted";
	

	$not=new Notifications();
	            $stf=Staff::find_by_staff_id($_POST['staff_name']);			          
			    $not->sender=$session->user_id;		
				$not->receiver=$hr->staff_id;
				$not->subject=" Leave Approval";
				$not->message="I Have Approved  A Leave Application For ". $stf->first_name ." ". $stf->last_name .",Please Make The Necessary Facilitations";
				$not->status="inbox";
				$not->save();
	
	
	
	}
	else{
	 $message="";
	}
}
if(isset($_POST['reject'])){

$apps=Applications::find_by_application_id($_POST['app_id']);
	$apps->manager_status="rejected";
	$apps->status="rejected";
	if($apps->save()){
	$message_type="success";
	$message="Application Rejected";
	
	
	$not=new Notifications();
	            
				$stf=Staff::find_by_staff_id($session->user_id);			             
			    $not->sender=$session->user_id;				
				$not->receiver=$_POST['staff_id'];
				$not->subject="Leave Application Rejected";
				$not->message="Your Leave Application Has Cancelled ";
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
	//if($app->manager_status==null){echo $app->status;}else{echo  $app->manager_status; }

?>




<?php include_layout_template('header'); ?>
<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="applications.php" class="active">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="applications.php" class="active">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
						<?php if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Received Applications</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				
				<div class="details">
				<fieldset>
				<legend>Details</legend>
				<table>
				<tr><th>#</th><th><u>STAFF NAME</u></th><th><u>DEPARTMENT</u></th><th><u>LEAVE</u></th><th><u>START</u></th><th><u>END</u></th><th><u>DAYS</u></th><th><u>STATUS</u></th><th><u>ACTION</u></th></tr>
			 
			 <?php $no=1; foreach($applications as $app): 
			 $stf=Staff::find_by_staff_id($app->staff_id);
			 if($stf->department_id==$me->department_id && $stf->staff_id!=$session->user_id){
           			 
					 
			 ?>
				<tr> <form method="post" action="applications.php"><td><?php echo $no;?></td><td><?php  echo $stf->first_name." ".$stf->last_name;?></td><td><?php $dept=Department::find_by_department_id($stf->department_id); echo $dept->department_name;?></td><td><?php $l=Leave::find_by_leave_id($app->leave_id);echo  $l->leave_name;?></td><td><?php echo $app->date_from;?></td><td><?php echo $app->date_to;?></td><td><?php echo $d =$days_on_leave=Holidays::days_on_leave_Weekends_and_Holidays_removed($app->date_from,$app->date_to);?></td><td><?php if($app->manager_status==null){echo $app->status;}else{echo  $app->manager_status; }?>
				
				</td><td>
				<?php if($app->status=="cancelled" || $app->manager_status=="rejected" || $app->manager_status=="granted"){ }
				else{?><input type="hidden" name="app_id" value="<?php echo $app->application_id;?>"><input type="hidden" name="staff_id" value="<?php  echo $stf->first_name." ".$stf->last_name ?>"><input type="hidden" name="staff_name" value="<?php  echo $stf->staff_id?>"><input type="submit" value="Grant" name="grant"><input type="submit" value="Reject" name="reject">
				<?php  }} else {} ?>
				
				</td></form></tr>
				<?php $no++; endforeach;?>
				</table>
				</fieldset>
				</div>
				
				
				</p></div>


</article></div>
                    </div>
                </div>
            </div><?php include_layout_template('footer'); ?>