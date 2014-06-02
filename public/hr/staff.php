<?php require_once("../../includes/initialize.php");?>
<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}


if(isset($_POST['submit'])){
	if(isset($_POST['staff_id'])){
	$staff_2=Staff::find_by_staff_id($_POST['staff_id']);
	$duplicate_staff=Staff::find_staff_by_name($_POST['first_name'],$_POST['last_name']);
		if($duplicate_staff && $staff_2->first_name!=$_POST['first_name'] && $staff_2->last_name!=$_POST['last_name']){
	
		$message_type="error";
		$message="A staff with the same name already exists in the system";
		
		}
		else{	
		$staff=Staff::find_by_staff_id($_POST['staff_id']);
		$staff->first_name=trim($_POST['first_name']);
		$staff->last_name=trim($_POST['last_name']);
		$staff->contract_type=trim($_POST['contract_type']);
		$staff->balance=trim($_POST['balance']);
		$staff->gender=trim($_POST['gender']);
		$staff->department_id=trim($_POST['department_id']);
		

		if($staff->save()){
		$message="You have Successfully Edited Staff Information";
		$message_type="success";
		}
		else{
		$message_type="error";
		$message="Nothing To Be Updated. Information Remained The same";
		}
	
		}
	}
	else{
		$staff=new Staff();
		$duplicate_staff=Staff::find_staff_by_name($_POST['first_name'],$_POST['last_name']);
		if($duplicate_staff){
		$message_type="error";
		$message="A staff with the same name already exists in the system";
		}
		else{
		$username=mt_rand(10000, 99999);
		$password=uniqid();
	    $staff->first_name=trim($_POST['first_name']);
	    $staff->last_name=trim($_POST['last_name']);
		$staff->contract_type=trim($_POST['contract_type']);
		$staff->balance=trim($_POST['balance']);
		$staff->gender=trim($_POST['gender']);
		$staff->status="session";
		$staff->department_id=trim($_POST['department_id']);
	    $staff->username=$username;
        $staff->password=$password;	

		if($staff->save()){
		$message_type="success";
		$message="You Have Successfully Registered A Staff. USERNAME is  <b>". $username ."</b> PASSWORD is  <b>". $password ."</b>";
		}
		else{
		$message_type="error";
		$message="Registration Unsuccessful";
		}
		}
	}
}

if(isset($_GET['action'])){
	 if(isset($_GET['staff_id'])){
		 if($_GET['action']=='delete'){
			$staff=Staff::find_by_staff_id($_GET['staff_id']);
			if(!empty($staff)){
				if($staff->delete()){
				    $message_type="success";
					$message=" Staff Deleted succesfully";
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
	 $message_type="error";
	    $message="You did not provide staff ID no action taken";
	 }
}
$staffs=Staff::find_all_except_hr($session->user_id);


//$staffs=Staff::find_all();//select all staffs
$dept=Department::find_all();//selects all departments


?>


<?php include_layout_template('header'); ?>




<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="active">Staff</a></li><li><a href="managers.php">Managers</a></li><li><a href="leaves.php">Leaves</a></li><li><a href="holidays.php">Holidays</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="active">Staff</a></li><li><a href="managers.php">Managers</a></li><li><a href="leaves.php">Leaves</a></li><li><a href="holidays.php">Holidays</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
							<?php if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Staff Administration</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				<div class="register">
				<?php 
				 if((isset($_GET['action']))&&($_GET['action']=='edit')){
					 $staff=Staff::find_by_staff_id($_GET['staff_id']);
				?>
              <fieldset>		
				<legend>Edit</legend>
			 	<form method="post" action="staff.php">
				<div class="fields"><b>FIRST NAME</b></div>
				<div class="fields"><input type="text" name="first_name" value="<?php echo $staff->first_name;?>"title="only characters are allowed" required pattern="[a-z A-Z]+"/></div>
				<div class="fields"><b>LAST NAME</b></div>
				<div class="fields"><input type="text" name="last_name" value="<?php echo $staff->last_name; ?>" title="only characters are allowed" required pattern="[a-z A-Z]+"/></div>
				<div class="fields"><b>TERMS</b></div>
				<div class="fields"><select name="contract_type"><option value="permanent">PERMANENT</option><option value="temporary">TEMPORARY</option></select></div>
				<div class="fields"><b>GENDER </b> 
				male<input type="radio" name="gender" value="male" checked="checked"//>
				female<input type="radio" name="gender" value="female"></div>
				<div class="fields"><b>DEPARTMENT NAME</b></div>
				<div class="fields"><select name="department_id">
				
				
				<?php $no=1; foreach($dept as $department): ?>
				<option value="<?php echo $department->department_id;?>"><?php echo $department->department_name;?></option>
				 <?php $no++; endforeach;?>
				 
				 </select> </div>	
				<div class="fields"><b>LEAVE BALANCE</b></div>
				<div class="fields"><input type="number" name="balance"  value="<?php echo $staff->balance; ?>" title="positive numbers only to a maximum of 1000" min="0" max="1000" required pattern="[0-9]+"/></div>
				<input type="hidden" name="staff_id" value="<?php echo $staff->staff_id; ?>"/>
				<div class="fields"><input type="submit" value="Save " name="submit"></div>
				</form>
				</fieldset>	
                 <?php 
				}
				else{
				?>
				
				
				
				<fieldset>		
				<legend>Register</legend>
			 	<form method="post" action="staff.php">
				<div class="fields"><b>FIRST NAME</b></div>
				<div class="fields"><input type="text" name="first_name" title="only characters are allowed" required pattern="[a-z A-Z]+"/></div>
				<div class="fields"><b>LAST NAME</b></div>
				<div class="fields"><input type="text" name="last_name" title="only characters are allowed" required pattern="[a-z A-Z]+"/></div>
				<div class="fields"><b>TERMS</b></div>
				
				<div class="fields"><select name="contract_type">
				<option value="permanent">PERMANENT</option>
				<option value="temporary">TEMPORARY</option></select></div>
				
				<div class="fields"><b>GENDER</b>
				male<input type="radio" name="gender" value="male" checked="checked"/>
				female<input type="radio" name="gender" value="female"></div>
				
				<div class="fields"><b>DEPARTMENT NAME</b></div>
				<div class="fields"><select name="department_id">
				
				
				<?php $no=1; foreach($dept as $department): ?>
				<option value="<?php echo $department->department_id;?>"><?php echo $department->department_name;?></option>
				 <?php $no++; endforeach;?>
				 
				 </select> </div>	
				
				<div class="fields"><b>LEAVE BALANCE</b></div>				
				<div class="fields"><input type="number" name="balance" title="positive numbers only to a maximum of 1000" min="0" max="1000" required pattern="[0-9]+"/></div>
				<div class="fields"><input type="submit" value="Register" name="submit"></div>
				</form>
				</fieldset>	
				
                <?php }?>				

				
				</div>
				
				<div class="details">
				<fieldset>
				<legend>Details</legend>
				<table>
				<tr><th>#</th><th><u>STAFF NAME</u></th><th><u>SEX</u></th><th><u>DEPARTMENT</u></th><th><u>ACCOUNT</u></th><th><u>TERMS</u></th><th><u>STATUS</u></th><th><u>ACTION</u></th></tr>
					
					
					
					<?php $no=1; foreach($staffs as $staff): ?>
				<tr><td><?php echo $no;?></td><td><?php echo $staff->first_name." ".$staff->last_name;?></td>
				<td><?php echo $staff->gender;?></td>
				<td><?php
				$department=Department::find_by_department_id($staff->department_id);
				echo $department->department_name;
				?>
				
				</td>
				<td><?php echo $staff->balance;?></td>
				<td><?php echo $staff->contract_type;?></td>
				<td><?php echo $staff->status;?></td>
				<td><a href="staff.php?staff_id=<?php echo $staff->staff_id?>&action=delete"><input type="button" value="delete"></a><a href="staff.php?staff_id=<?php echo $staff->staff_id?>&action=edit"><input type="button" value="edit"></a></td></tr>
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