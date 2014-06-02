<?php require_once("../../includes/initialize.php");?>
<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}

if(isset($_POST['submit'])){
	if(isset($_POST['holiday_id'])){	
	    $duplicate_1=Holidays::find_by_holiday_name($_POST['holiday_name']);
		$dup=Holidays::find_by_holiday_id($_POST['holiday_id']);
		if($duplicate_1 && $dup->holiday_name!=$_POST['holiday_name'] && $dup->holiday_date!=$_POST['holiday_date']){
		
		$message_type="error";
		$message="A Holiday with the same name already exists in the system";
			}
	
		else{
		$holiday=Holidays::find_by_holiday_id($_POST['holiday_id']);
		$holiday->holiday_name=trim($_POST['holiday_name']);

		$holiday->holiday_date=trim(date('d-F',strtotime($_POST['holiday_date'])));

		if($holiday->save()){
		$message_type="success";
			$message="Chages Successfully Saved";
		}
		else{
		$message_type="error";
		$message="Nothing To Be Updated. Information Remained The same";
		   }
		}
	}
	
	
	
	
	
	
	else{
	
	$duplicate=Holidays::find_by_holiday_name($_POST['holiday_name']);
	if($duplicate){
	$message_type="error";
    $message="A Holiday with the same name already exists in the system";
	}
	else{
		$holiday=new Holidays();
	    $holiday->holiday_name=trim($_POST['holiday_name']);
		$holiday->holiday_date=trim(date('d-F',strtotime($_POST['holiday_date'])));

		if($holiday->save()){
		$message_type="success";
			$message="Holiday Successfully Saved";
		}
		else{
		$message_type="error";
		$message="not success";
		 }
		}		
	}	
}

if(isset($_GET['action'])){
	 if(isset($_GET['holiday_id'])){
		 if($_GET['action']=='delete'){
			$holiday=Holidays::find_by_holiday_id($_GET['holiday_id']);
			if(!empty($holiday)){
				if($holiday->delete()){
				$message_type="success";
					$message="Delete succesful";
				}
				else{
				$message_type="error";
					$message="Delete failed";
				}
			 }
			 else{
			 $message_type="error";

			 $message="No record";
			 }
		 }
	}
	 else{
	 $message_type="error";
	    $message="You did not provide Holiday ID no action taken";
	 }
}






//select all for diaplay
$holidays=Holidays::find_all();

$today=Date("Y-m-d");


?>




<?php include_layout_template('header'); ?>



<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="">Managers</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="holidays.php" class="active">Holidays</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="departments.php" class="">Departments</a></li><li><a href="staff.php" class="">Staff</a></li><li><a href="managers.php" class="">Managers</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="holidays.php" class="active">Holidays</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li><li><a href="#">Settings</a><ul><li><a href="settings/my-account.php">My Account</a></li><li><a href="settings/user-account.php">User Account</a></li></ul></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
						<?php if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Holiday Administration</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				<div class="register">
                <?php 
				 if((isset($_GET['action']))&&($_GET['action']=='edit')){
					 $holiday=Holidays::find_by_holiday_id($_GET['holiday_id']);
				?>				
             <fieldset>		
				<legend>Edit</legend>
				<form method="POST" action="holidays.php">
				<div class="fields">HOLIDAY NAME</div>
				<div class="fields"><input type="text" name="holiday_name"  value="<?php echo $holiday->holiday_name; ?>"title="only characters are allowed" required pattern="[a-z A-Z]+"/></div>
				<div class="fields">HOLIDAY DATE</div>
				<div class="fields"><input type="date" name="holiday_date"  value="<?php echo $holiday->holiday_date; ?>" required/></div>
				<input type="hidden" name="holiday_id" value="<?php echo $holiday->holiday_id; ?>"/>
				<div class="fields"><input type="submit" value="Save Changes" name="submit"></div>
				</form>
				</fieldset>				
				
				
				<?php 
				}
				else{
				?>
				 <fieldset>		
				<legend>Register</legend>
				<form method="POST" action="holidays.php">
				<div class="fields">HOLIDAY NAME</div>
				<div class="fields"><input type="text" name="holiday_name" title="only characters are allowed" required pattern="[a-z A-Z]+"/></div>
				<div class="fields">HOLIDAY DATE</div>
				<div class="fields"><input type="date" name="holiday_date"  required/></div>
				<div class="fields"><input type="submit" value="REGISTER" name="submit"></div>
				</form>
				</fieldset>	
				<?php }?>
			</div>
			<div class="details">
				<fieldset>
				<legend>Details</legend>
				<table>
				<tr><th>#</th><th><u>HOLIDAY</u></th><th><u>DATE</u></th><th><u>ACTION</u></th></tr>
				<?php $no=1; foreach($holidays as $holiday): ?>
				<tr><td><?php echo $no;?></td><td><?php echo $holiday->holiday_name;?></td><td><?php echo $holiday->holiday_date;?></td><td><a href="holidays.php?holiday_id=<?php echo $holiday->holiday_id?>&action=delete"><input type="button" value="delete"></a><a href="holidays.php?holiday_id=<?php echo $holiday->holiday_id?>&action=edit"><input type="button" value="edit"></a></td></tr>
				
				 <?php $no++; endforeach;?>
				</table>
				</fieldset>
				</div>
				
				
				
				</p></div>


</article></div>
                    </div>
                </div>
            </div><?php include_layout_template('footer'); ?>