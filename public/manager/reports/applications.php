<?php require_once("../../../includes/initialize.php");?>
<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}

?>
<?php include_layout_template('header_subfolder'); ?>
<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="../home.php" class="">Home</a></li><li><a href="../applications.php" class="">Applications</a></li><li><a href="../mails.php" class="">Mails</a></li><li><a href="../reports.php" class="active">Reports</a><ul class="active"><li><a href="../reports/applications.php" class="active">Applications</a></li><li><a href="../reports/history.php">History</a></li><li><a href="../reports/my-activities.php">My Activities</a></li><li><a href="../reports/staff-on-leave.php">staff on leave</a></li></ul></li></ul> 
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
<ul class="art-vmenu"><li><a href="../home.php" class="">Home</a></li><li><a href="../applications.php" class="">Applications</a></li><li><a href="../mails.php" class="">Mails</a></li><li><a href="../reports.php" class="active">Reports</a><ul class="active"><li><a href="../reports/applications.php" class="active">Applications</a></li><li><a href="../reports/history.php">History</a></li><li><a href="../reports/my-activities.php">My Activities</a></li><li><a href="../reports/staff-on-leave.php">staff on leave</a></li></ul></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">New Page</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix"><p><br/></p></div>


</article></div>
                    </div>
                </div>
            </div><?php include_layout_template('footer'); ?>