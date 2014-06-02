<?php require_once("../../includes/initialize.php");?>
<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}


if(isset($_POST['submit'])){
	if(isset($_POST['leave_id'])){
	    $this_leave=Leave::find_by_leave_id($_POST['leave_id']);
        $duplicate1=Leave::find_by_leave_name($_POST['leave_name']);
		
		if($duplicate1 && $this_leave->leave_name!=$_POST['leave_name']){
		$message_type="error";
         $message="A leave with the same name already exists in the system";
		
		}
	
		else{
		$leave=Leave::find_by_leave_id($_POST['leave_id']);
		$leave->leave_name=trim($_POST['leave_name']);
		$leave->leave_type=trim($_POST['leave_type']);
		$leave->max_days=trim($_POST['max_days']);
		$leave->qualification=trim($_POST['qualification']);
		$leave->applicability=trim($_POST['applicability']);

		if($leave->save()){
		$message_type="success";
			$message="Changes successfully Saved";
		}
		else{
		$message_type="error";
		$message="Nothing To Be Updated. Information Remained The same";
		
		}
	}
}

	else{
	$duplicate=Leave::find_by_leave_name($_POST['leave_name']);
	if($duplicate){
	$message_type="error";
	$message="A leave with the same name already exists in the system";
	}
	else{
	
			
		$leave=new Leave();
		$leave->leave_name=trim($_POST['leave_name']);
		$leave->leave_type=trim($_POST['leave_type']);
		$leave->max_days=trim($_POST['max_days']);
		$leave->qualification=trim($_POST['qualification']);
		$leave->applicability=trim($_POST['applicability']);

		if($leave->save()){
		$message_type="success";
			$message="Leaves Successfully Registered";
		}
		else{
		$message_type="error";
		$message="Error in Registering Leave";
		}
	  }
	}
}





if(isset($_GET['action'])){
	 if(isset($_GET['leave_id'])){
		 if($_GET['action']=='delete'){
			$leave=Leave::find_by_leave_id($_GET['leave_id']);
			if(!empty($leave)){
				if($leave->delete()){
				$message_type="success";
					$message="Delete succesful";
				}
				else{
				$message_type="error";
					$message="Delete failed";
				}
			 }
			 else{
			 $message="No record";
			 }
		 }
	}
	 else{
	
	 }
}



if(isset($_GET['action'])){
	 if(isset($_GET['leave_id'])){
		 if($_GET['action']=='credit'){	
		 
		 
$leave=Leave::find_by_leave_id($_GET['leave_id']);
$staff=Staff::find_all();

foreach($staff as $staff):

if(($staff->contract_type==$leave->qualification || $leave->qualification=="all") && ($staff->gender==$leave->applicability || $leave->applicability=="all")){
		
		$total=$staff->balance+$leave->max_days;
        $staff->balance=$total;
		if($staff->save()){
		$message_type="success";
		$message="All accounts that qualify have been credited";
		}
		else{
		$message_type="error";
		$message="Nothing To Be Updated. Information Remained The same";
		}
}		
		
else{}
endforeach;	 

	
	}

}
}






//select all for diaplay
$leaves=Leave::find_all();






?>
<?php include_layout_template('header'); ?>



<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="">Managers</a></li><li><a href="leaves.php" class="active">Leaves</a></li><li><a href="holidays.php">Holidays</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="">Managers</a></li><li><a href="leaves.php" class="active">Leaves</a></li><li><a href="holidays.php">Holidays</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
							<?php if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Leave Administration</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				
				<div class="register">	
				<?php 
				 if((isset($_GET['action']))&&($_GET['action']=='edit')){
					 $leave=Leave::find_by_leave_id($_GET['leave_id']);
				?>
				
             <fieldset>		
				<legend>Edit</legend>
			 	<form method="POST" action="leaves.php">
				<div class="fields"><b>LEAVE NAME</b></div>
				<div class="fields"><input type="text" name="leave_name" value="<?php echo $leave->leave_name; ?>" title="only characters are allowed" required pattern="[a-z A-Z]+"/></div>
				<div class="fields"><b>LEAVE TYPE</b></div>
				<div class="fields"><select name="leave_type"><option value="annual">ANNUAL</option><option  value="spontaneous">SPONTANEOUS</option></select></div>
				<div class="fields"><b>MAXIMUM DAYS</b></div>
				<div class="fields"><input type="number" name="max_days" value="<?php echo $leave->max_days; ?>" title="positive numbers only to a maximum of 1000" min="0" max="1000" required pattern="[0-9]+"/></div>				
				<div class="fields"><b>QUALIFICATION</b></div>
				<div class="fields"><select name="qualification"><option value="temporary">TEMPORARY STAFF</option><option value="permanent">PERMANENT STAFF</option><option value="ALL">ALL STAFF</option></select></div>
				<div class="fields"><b>APPLICABILITY</b></div>
				<div class="fields"><select name="applicability"><option value="male">MALE STAFF</option><option  value="female">FEMALE STAFF</option><option  value="all">ALL GENDER</option></select></div>
					<input type="hidden" name="leave_id" value="<?php echo $leave->leave_id; ?>"/>
				<div class="fields"><input type="submit" value="Save Changes" name="submit"></div>
				</form>
				</fieldset>	
				
				<?php 
				}
				else{
				?>
				 <fieldset>		
				<legend>Register</legend>
				<form method="post" action="leaves.php">
			 	<div class="fields"><b>LEAVE NAME</b></div>
				<div class="fields"><input type="text" name="leave_name" title="only characters are allowed" required pattern="[a-z A-Z]+"/></div>
				<div class="fields"><b>LEAVE TYPE</b></div>
				<div class="fields"><select name="leave_type"><option value="annual">ANNUAL</option><option  value="spontaneous">SPONTANEOUS</option></select></div>
				<div class="fields"><b>MAXIMUM DAYS</b></div>
				<div class="fields"><input type="number" name="max_days" title="positive numbers only to a maximum of 1000" min="0" max="1000" required pattern="[0-9]+"/></div>				
				<div class="fields"><b>QUALIFICATION</b></div>
				<div class="fields"><select name="qualification"><option value="temporary">TEMPORARY STAFF</option><option value="permanent">PERMANENT STAFF</option><option value="all">ALL STAFF</option></select></div>
				<div class="fields"><b>APPLICABILITY</b></div>
				<div class="fields"><select name="applicability"><option value="male">MALE STAFF</option><option  value="female">FEMALE STAFF</option><option  value="all">ALL GENDER</option></select></div>
				<div class="fields"><input type="submit" value="REGISTER" name="submit"></div>
				
				</form>
				</fieldset>
				
              <?php }?>
				
				</div>
				
				<div class="details">
				<fieldset>
				<legend>Details</legend>
				<table>
				<tr><th>#</th><th><u>LEAVE NAME</u></th><th><u>LEAVE TYPE</u></th><th><u>DAYS</u></th><th><u>QUALIFICATION</u></th><th><u>APP..</u></th><th><u>ACTION</u></th></tr>
				<?php $no=1; foreach($leaves as $leave): ?>
				<tr><td><?php echo $no;?></td><td><?php echo $leave->leave_name;?></td><td><?php echo $leave->leave_type;?></td><td><?php echo $leave->max_days;?></td><td><?php echo $leave->qualification;?></td><td><?php echo $leave->applicability;?></td><td><a href="leaves.php?leave_id=<?php echo $leave->leave_id?>&action=delete"><input type="button" value="delete"></a><a href="leaves.php?leave_id=<?php echo $leave->leave_id?>&action=edit"><input type="button" value="edit"></a><?php if($leave->leave_type=="spontaneous"){}else{?><a href="leaves.php?leave_id=<?php echo $leave->leave_id?>&action=credit"><input type="button" value="credit"></a><?php } ?></td></tr>
				 <?php $no++; endforeach;?>
				</table>
				</fieldset>
				</div>
				
				
				
				
				
				</p></div>


</article></div>
                    </div>
                </div>
            </div><?php include_layout_template('footer'); ?>