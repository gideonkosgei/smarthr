<?php require_once("../../includes/initialize.php");?>

<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}



if(isset($_POST['cancel'])){
	$app=Applications::find_by_application_id($_POST['app_id']);
	$app->status="cancelled";
	if($app->save()){
	$message_type="success";
	$message="Application cancelled Successfully";
	
	$not=new Notifications();
	            $is_hr=Staff::find_by_staff_id($session->user_id);
	            $stf=Staff::find_by_staff_id($session->user_id);
			    $man=Staff::manager_department($stf->department_id);	          
			    $not->sender=$session->user_id;				
				if($is_hr->adm=="hr"){
			   $not->receiver=$session->user_id;
			   }
                 else{				
				$not->receiver=$man->staff_id;
				}
				$not->subject="Cancellation Of LeaveApplication Request";
				$not->message="I Have Cancelled My Leave Application";
				$not->status="inbox";
				$not->save();
	
	}
	else{

	}
	}

	
//$applications=Applications::find_all();//select all applications
$applications=Applications::find_my_applications($session->user_id)
?>
<?php include_layout_template('header'); ?>
<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="applications.php" class="active">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="settings.php">Settings</a></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="applications.php" class="active">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="settings.php">Settings</a></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
							<?php if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">My Applied Leaves</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				
				<div class="details">
				<fieldset>
				<legend>Details</legend>
				<table>
				<tr><th>#</th><th><u>LEAVE NAME</u></th><th><u>START DATE</u></th><th><u>END DATE</u></th><th><u>DAYS ON LEAVE</u></th><th><u>LEAVE STATUS</u></th><th><u>ACTION</u></th></tr>
				<?php $no=1; foreach($applications as $applied): ?>
				
				<tr><form method="post" action="applications.php"><td><?php echo $no;?></td><td><?php $leave=Leave::find_by_leave_id($applied->leave_id);
				echo $leave->leave_name;?></td><td><?php echo $applied->date_from;?></td><td><?php echo $applied->date_to;?></td><td><?php  echo $d =$days_on_leave=Holidays::days_on_leave_Weekends_and_Holidays_removed($applied->date_from,$applied->date_to); ?></td><td><?php echo $applied->status;?></td><td><input type="hidden" name="app_id" value="<?php echo $applied->application_id;?>">

<?php
if($applied->status=="cancelled" || $applied->status=="granted" || $applied->status=="rejected"){
}else{?>

<input type="submit" value="cancel" name="cancel">
<?php
}
?>

				
				
				
				
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