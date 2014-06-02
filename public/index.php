<?php
require_once("../includes/initialize.php");
?>


<?php
if($session->is_logged_in()){
//redirect staff to specific section
echo $session->user_id;
$logged_in_staff=Staff::find_by_staff_id($session->user_id);
if($logged_in_staff){
   if($logged_in_staff->type=="hr"){
    redirect_to('hr/index.php');
   }
   else if($logged_in_staff->type=="manager"){
    redirect_to('manager/index.php');
   }
   else{
    redirect_to('staff/index.php');
   }

}
else{
redirect_to('login.php');
}
}
else{
redirect_to('login.php');
}


?>