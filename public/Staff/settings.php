<?php require_once("../../includes/initialize.php");?>

<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}

$logged_in_staff=Staff::find_by_staff_id($session->user_id);
if(isset($_POST['submit'])){
 
    if(trim($_POST['old_password'])!= $logged_in_staff->password){
            $message_type="error";	
			$message="The Old Password You Have Provided Does Not Match With The One In The System";		
	}
	    else if($_POST['password']!=$_POST['con_password']){
		               $message_type="error";
						$message="passWord fields did not match";
		}
			else if(isset($_POST['staff_id'])){
         //change password
					$logged_in_staff->password=trim($_POST['password']);
                    $logged_in_staff->username=trim($_POST['username']);					
					if($logged_in_staff->save()){
					$message_type="success";
					$message="Login Credentials Successfully changed";
					}
					else{
					$message_type="error";	
					$message="Nothing Has Changed.Credentials Remained The Same";
					}
		
		    }

	}
?>
<?php include_layout_template('header'); ?>

<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="applications.php" class="">Applications</a></li><li><a href="mails.php" class="">Mails</a></li><li><a href="settings.php" class="active">Settings</a></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="applications.php" class="">Applications</a></li><li><a href="mails.php" class="">Mails</a></li><li><a href="settings.php" class="active">Settings</a></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
						<?php if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Change Password</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p>
				
				
				<div class="register">	
			
				
             <fieldset>		
				<legend>Account</legend>
			
				
				<form method="post" action="settings.php">
				<div class="fields">OLD PASSWORD</div>
				<div class="fields"><input type="password" name="old_password"required/></div>
				<div class="fields">NEW USERNAME</div>
				<div class="fields"><input type="text" name="username" required/></div>
				<div class="fields">NEW PASSWORD</div>
				<div class="fields"><input type="password" name="password" required/></div>
				<div class="fields">CONFIRM PASSWORD</div>
				<div class="fields"><input type="password" name="con_password" required/></div>
				<input type="hidden" name="staff_id" value="<?php $logged_in_staff->staff_id; ?>"/>
				<div class="fields"><input type="submit" value="CHANGE" name="submit"></div>
				 </form>
				 
				</fieldset>	
	            				
			</div>
				
				
				
				</p></div>


</article></div>
                    </div>
                </div>
            </div><?php include_layout_template('footer'); ?>