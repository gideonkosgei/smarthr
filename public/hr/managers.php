<?php require_once("../../includes/initialize.php");?>
<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}






if(isset($_POST['submit'])){
$s=Staff::find_by_staff_id($_POST['staff_id']);
	if(isset($_POST['staff_id'])){

		$manager_department=Staff::manager_department($_POST['department_id']);
		if($s->department_id!=$_POST['department_id']){
		$message_type="error";
		$message="The user Does Not Belong To That Department. Make Necessary Changes Then Continue";
		}
		else if($s->manager=="yes"){
		$message_type="error";
		$message="The Staff Selected Is Already A manager ";
		}
		else if(!empty($manager_department)){
		$message_type="error";
		$message="Department Already Has A Manager";
		}
		else{
		$s->manager="yes";
		$s->adm="manager";
		$s->type="manager";
	
		

		if($s->save()){
		$message_type="success";
			$message=" The Assignment Was Successful";
			
		}
		else{
		
		}
		}
	}
	else{

		
	}
}
if(isset($_POST['remove'])){
$s=Staff::find_by_staff_id($_POST['staff_id']);
	if(isset($_POST['staff_id'])){
		

	
		$s->manager="no";
		$s->adm=null;
		$s->type="regular";
	
		

		if($s->save()){
		$message_type="success";
			$message=" Manager Removed successfully";
			
		}
		else{
		
		
		}
		
	}
	else{

		
	}
}



$dept=Department::find_all();//selects all departments
//$stf=Staff::find_all();//selects all departments
$stf=Staff::find_all_except_hr($session->user_id);
$man=Staff::find_all_managers();




?>


<?php include_layout_template('header'); ?>



<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="active">Managers</a></li><li><a href="leaves.php">Leaves</a></li><li><a href="holidays.php">Holidays</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="active">Managers</a></li><li><a href="leaves.php">Leaves</a></li><li><a href="holidays.php">Holidays</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
							<?php if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Managers Administration</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				<div class="register">
				
				
                <fieldset>		
				<legend>Register</legend>
			 	<form method="post" action="managers.php">				
				<div class="fields"><b>UNIT NAME</b></div>
				<div class="fields"><select name="department_id">
				
				
				<?php $no=1; foreach($dept as $department): ?>
				<option value="<?php echo $department->department_id;?>"><?php echo $department->department_name;?></option>
				 <?php $no++; endforeach;?>
				 
				 </select> </div>	
				<div class="fields"><b>STAFF NAME</b></div>
				<div class="fields"><select name="staff_id">
				
				
				<?php $no=1; foreach($stf as $staff): ?>
				<option value="<?php echo $staff->staff_id;?>"><?php echo $staff->first_name." ". $staff->last_name;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
				 <?php $no++; endforeach;?>
				 
				 </select> </div>	
				<div class="fields"><input type="submit" value="REGISTER" name="submit"></div>
				</form>
				</fieldset>	
			

				
				</div>
				
				<div class="details">
				<fieldset>
				<legend>Details</legend>
				<table>
				<tr><th>#</th><th><u>DEPARTMENT NAME</u></th><th><u>MANAGER NAME</u></th><th><u>ACTION</u></th></tr>
				<?php $no=1; foreach($man as $staff): ?>
				<tr><td><form method="post" action="managers.php"><?php echo $no;?></td><td><?php $department=Department::find_by_department_id($staff->department_id);
				echo $department->department_name;?></td><td><?php echo $staff->first_name." ". $staff->last_name;?></td><td>
				<input type="hidden" name="staff_id" value="<?php echo $staff->staff_id; ?>">
				<input type="submit" value="remove" name="remove"></form>
				</td></tr>
				
				 <?php $no++; endforeach;?>
				</table>
				</fieldset>
				</div>
				
				
				
				</p></div>


</article></div>
                    </div>
                </div>
            </div><?php include_layout_template('footer'); ?>