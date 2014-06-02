<?php require_once("../../../includes/initialize.php");?>
<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}


if(isset($_POST['lock'])){
$staff=Staff::find_by_staff_id($_POST['staff_id']);

	if(isset($_POST['staff_id'])){

			if($staff->locked=="no"){
			     $staff->locked="yes";
			
					if($staff->save()){
					$message_type="success";
					$message=" The Account Was Locked Successfully";
					}
					else{
					$message_type="error";
					$message="The account Was Not Locked Successfully";
					}
			}
		else{
		$staff->locked="no";
		
			if($staff->save()){
			$message_type="success";
			$message="The Account Was Successly Unlocked";
			}
			else{
			$message_type="error";
			$message="The Account was Not Successfully Unlocked";
			}
		}
	}
}
else{
	if(isset($_POST['staff_id'])){
	$staff=Staff::find_by_staff_id($_POST['staff_id']);
	$staff->password=uniqid();
	if($staff->save()){
	$message=" PASSWORD changed succcessfully. New Password Is <b>".$staff->password."</b>";
	$message_type="success";
	}
	else{
	
	 $message="not success";
	}
	}
	
	
		
}


$staffs=Staff::find_all_except_hr($session->user_id);//select all staffs




?>
<?php include_layout_template('header_subfolder'); ?>

<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="../home.php" class="">Home</a></li><li><a href="../departments.php" class="">Departments</a></li><li><a href="../staff.php" class="">Staff</a></li><li><a href="../managers.php" class="">Managers</a></li><li><a href="../leaves.php" class="">Leaves</a></li><li><a href="../holidays.php" class="">Holidays</a></li><li><a href="../applications.php" class="">Applications</a></li><li><a href="../mails.php" class="">Mails</a></li><li><a href="../reports.php" class="">Reports</a></li><li><a href="#" class="active">Settings</a><ul class="active"><li><a href="../settings/my-account.php" class="">My Account</a></li><li><a href="../settings/user-account.php" class="active">User Account</a></li></ul></li></ul> 
    <ul class="art-hmenu" style="float:right;">
	<li> <span style="text-align:justify;">
	
	<p><a href="../logout.php"><img src="../../images/logout.png" alt="logout"></a></p>
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
<ul class="art-vmenu"><li><a href="../home.php" class="">Home</a></li><li><a href="../departments.php" class="">Departments</a></li><li><a href="../staff.php" class="">Staff</a></li><li><a href="../managers.php" class="">Managers</a></li><li><a href="../leaves.php" class="">Leaves</a></li><li><a href="../holidays.php" class="">Holidays</a></li><li><a href="../applications.php" class="">Applications</a></li><li><a href="../mails.php" class="">Mails</a></li><li><a href="../reports.php" class="">Reports</a></li><li><a href="#" class="active">Settings</a><ul class="active"><li><a href="../settings/my-account.php" class="">My Account</a></li><li><a href="../settings/user-account.php" class="active">User Account</a></li></ul></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
						<?php if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">User Accounts</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				<div class="details">
				<fieldset>
				<legend>Details</legend>
				<table>
				<tr><th>#</th><th><u>STAFF NAME</u></th><th><u>DEPARTMENT</u></th><th><u>ACTION</u></th></tr>
				<?php $no=1; foreach($staffs as $staff): 
				$dept=Department::find_by_department_id($staff->department_id);
				
				?>
				
				   <tr>
				   <td><form action="user-account.php" method="post">
				   <?php echo $no;?></td>
				   <td><?php echo $staff->first_name." ".$staff->last_name;?></td>
				   <td><?php echo $dept->department_name;?></td>
				   <td>
				
				<?php if($staff->locked=="no") { ?>
					   <input type="submit" value="lock" name="lock">
					   <?php }
					   else { ?>
					   <input type="submit" value="unlock" name="lock">
					   <?php }?>				   
					   
				   <input type="submit" value="Change Password" name="change_password"><input type="hidden"  name="staff_id"value="<?php echo $staff->staff_id?>"></form></td></tr>
				<?php $no++; endforeach;?>
				</table>
				</fieldset>
				</div>
				
				
				
				
				</p></div>


</article></div>
                    </div>
                </div>
            </div><?php include_layout_template('footer'); ?>