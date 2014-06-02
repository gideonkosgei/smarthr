<?php require_once("../../includes/initialize.php");?>

<?php
if(!$session->is_logged_in())
{
redirect_to('login.php');
}
$person=Staff::find_by_id($session->user_id);

if(isset($_POST['submit'])){
	
		$not=new Notifications();
	    $not->sender=$session->user_id;
	    $not->receiver=$_POST['receiver'];
	    $not->subject=$_POST['subject'];
	    $not->message=$_POST['message'];
        $not->date_time=convertTimestamptoMySQLformat(time());

		if($not->save()){
		$message_type="success";
			$message="Message Sent";
		}
		else{
				}
	}
	
	
$recepient=Staff::find_manager_hr($person->department_id);




?>
<?php include_layout_template('header'); ?>

<nav class="art-nav">
    <ul class="art-hmenu"><li><a href="home.php" class="">Home</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="applications.php" class="">Applications</a></li><li><a href="mails.php" class="active">Mails</a></li><li><a href="settings.php">Settings</a></li></ul> 
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
<ul class="art-vmenu"><li><a href="home.php" class="">Home</a></li><li><a href="leaves.php" class="">Leaves</a></li><li><a href="applications.php" class="">Applications</a></li><li><a href="mails.php" class="active">Mails</a></li><li><a href="settings.php">Settings</a></li></ul>
                
        </div>
</div></div>
                        <div class="art-layout-cell art-content"><article class="art-post art-article">
						<?php if($message==""){}else{ echo "<div class='success'>".$message."</div>";}?>
                                <div class="art-postmetadataheader">
                                        <h2 class="art-postheader"><span class="art-postheadericon">Messages & Notifications</span></h2>
                                    </div>
                                                
                <div class="art-postcontent art-postcontent-0 clearfix">
				
				
				<div class="art-comments" id="comments">
				
	<?php 
    // 1. the current page number ($current_page)
		$notifications_page = !empty($_GET['notifications_page']) ? (int)$_GET['notifications_page'] : 1;

		// 2. records per page ($per_page)
		$notifications_per_page =4;

		// 3. total record count ($total_count)
		$notifications_total_count =count(Notifications::all_my_notifications($session->user_id));
	 

		// Find all photos
		// use pagination instead
		//$photos = Photograph::find_all();

		$notifications_pagination = new Pagination($notifications_page, $notifications_per_page, $notifications_total_count);

		// Instead of finding all records, just find the records 
		// for this page
		$notifications=Notifications::find_limited($notifications_per_page, $notifications_pagination->offset(), $session->user_id);
		
		// Need to add ?page=$page to all links we want to 
		// maintain the current page (or store $page in $session)

	foreach($notifications as $notification): 
	?>			
<div class="art-comment art-postcontent clearfix">



    <div class="art-comment-avatar"><img src="../images/no-avatar.jpg" alt="Avatar image"></div>
    <div class="art-comment-inner">
        <div class="art-comment-header"><?php  $sender=Staff::find_by_id($notification->sender);$receiver=Staff::find_by_id($notification->receiver);if($session->user_id==$notification->sender){echo "<b> Me >>> ". $receiver->first_name ." ". $receiver->last_name ."</b>";}else{echo "<b>".$sender->first_name ." ". $sender->last_name ." >>> Me </b>  ";}?>&nbsp;&nbsp;&nbsp;<?php echo "(".date('l jS\,F Y h:i:s A',strtotime($notification->date_time)).")<br/><br/><b>SUBJECT: ". $notification->subject ."</b>";?></div>
        <div class="art-comment-content"><?php echo $notification->message; ?></div>
        <div class="art-comment-footer">
            
        </div>
    </div>
	</div>
	<hr width="90%" align="center" size="thin">
	
	<?php  endforeach; ?>
				<div class="art-pager" style="float:right;">
	<?php 
	   if($notifications_pagination->total_pages() > 1) {
			
			if($notifications_pagination->has_previous_page()) { 
			echo "<a href=\"".$_SERVER['PHP_SELF']."?notifications_page=".$notifications_pagination->previous_page()."\">&laquo; Previous</a>"; 
			//<a href="#">&laquo; Previous</a>
			}
			for($i=1; $i <= $notifications_pagination->total_pages(); $i++) {
							if($i == $notifications_page) {
								echo "<span class=\"active\">{$i}</span>";
								//<span class="active">1</span>
							} else {
								echo "<a href=\"".$_SERVER['PHP_SELF']."?notifications_page={$i}\">{$i}</a>"; 
								//<a href="#">2</a>
								//<a href="#" class="more">...</a>
							}
						}

			if($notifications_pagination->has_next_page()) { 
					echo "<a href=\"".$_SERVER['PHP_SELF']."?notifications_page=".$notifications_pagination->next_page()."\">Next &raquo;</a>";
					//<a href="#">Next &raquo;</a>;
			}
		
		
		}
	?>
   </div>
	
	
	
	
	
</div>
<div class="messagebox">


    <h2 class="art-postheader">Send Message </h2>
    <form action="mails.php" method="post" id="commentform">
        <p class="comment-form-author">
            <label for="author"><b>Select Recepient</b></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <select name="receiver">
			<?php  foreach($recepient as $recepient):?>
			<option value="<?php echo $recepient->staff_id;?>" ><?php echo $recepient->first_name ." ".$recepient->last_name; ?></option>
			<?php endforeach;?>
			

			
			</select>
        </p>
        <p>
            <label><b>Subject</b></label>
            <input name="subject" type="text" size="30" required/>
        </p>
        <p class="comment-form-comment">
            <label for="comment"><b>Compose Message Body</b></label>
            <textarea id="comment" name="message" cols="45" rows="8" aria-required="true"></textarea>
        </p>                        
        <p align="center">
        <input name="submit" class="art-button" type="submit" value="Send Message" name="submit">
        </p>
    </form>
</div>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				</div>


</article></div>
                    </div>
                </div>
             </div><?php include_layout_template('footer'); ?>