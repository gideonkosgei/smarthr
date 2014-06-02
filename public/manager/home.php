<?php require_once("../../includes/initialize.php");?>

<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}
$stf=Staff::find_by_staff_id($session->user_id);

if(isset($_POST['toggle']))
{

	$stf->type="regular";
	if($stf->save()){
	$message_type="success";
	$message="Account Changed. It will Be Active In Your Next Login";
	
	}
	else{
	$message_type="error";
	 $message="Account Already Changed.Please Log Out First Before Another Toggle";
	}
}
?>




<?php include_layout_template('header'); ?>
<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="active">Home</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="active">Home</a></li><li><a href="applications.php">Applications</a></li><li><a href="mails.php">Mails</a></li><li><a href="reports.php">Reports</a></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
						<?php    
				
				if($message==""){}else if($message_type=="success"){ echo "<div class='success'>".$message."</div>";} else{ echo "<div class='error'>".$message."</div>";}
				?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Welcome <?php echo $stf->first_name." ".$stf->last_name;?> To <?php if($stf->type=="hr"){echo "HR";}else if($stf->type=="manager"){echo "Manager";}else{echo "Ordinary Staff";}?> Section</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><div class="art-content-layout">

				
				
				<div class="details"><h2>Click Toggle To change To <?php if($stf->type=="manager"){echo "Ordinary staff";} else{echo "Manager";}?> Account</h2></div><div class="details">&nbsp;&nbsp;&nbsp;
				
				<form method="post" action="home.php"><input type="submit" name="toggle"value="Toggle"/></form></div>
				
				
</div>


</article></div>
                    </div>
                </div>
            </div> <?php include_layout_template('footer'); ?>