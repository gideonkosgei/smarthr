<?php
require_once("../../includes/initialize.php");

$pdf = new PDF();
$staff=Staff::find_all();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$no=1;
$applications=Applications::find_all();//select all applications





//report1
if(isset($_POST['report1'])){
$apps=Applications:: find_application_between_date_range($_POST['date_from'],$_POST['date_to']);

$manager=Staff::manager_department($_POST['department']);
$dept=Department::find_by_department_id($_POST['department']);
$pdf->Cell(0,10,'DEPARTMENT: '. $dept->department_name,0,1,'A');
$pdf->Cell(0,10,'MANAGER: '. $manager->first_name ." ".$manager->last_name,0,1,'A');
$apps_by_dept=Applications::find_application_between_date_range_by_dept($_POST['date_from'],$_POST['date_to'],$_POST['department']);



$pdf->SetLineWidth(.3);
$pdf->SetFont('','B');
    // Header
$w = array(7,40,30,30,30,30);
	$header = array('#','NAME', 'LEAVE', 'START ','END ','APPLIED');

	
	//pages separator.
	$pdf->Cell(11,10,'',0,2);
	
    for($i=0;$i<count($header);$i++)
       $pdf->Cell($w[$i],7,$header[$i],1,0);
   $pdf->Ln();
    // Color and font restoration
   $pdf->SetFillColor(224,235,255);
   $pdf->SetTextColor(0);
   $pdf->SetFont('','','B');
    // Data
    $fill = false;
   

foreach($apps_by_dept as $apps):
$staff=Staff::find_by_staff_id($apps->staff_id);
$leave=Leave::find_by_leave_id($apps->leave_id);
    $pdf->Cell($w[0],5.5,$no,'LR',0,'L',$fill);
	$pdf->Cell($w[1],5.5,$staff->first_name ." ". $staff->last_name,'LR',0,'L',$fill);
    $pdf->Cell($w[3],5.5,$leave->leave_name,'LR',0,'LR',$fill);
	$pdf->Cell($w[4],5.5,$apps->date_from,'LR',0,'R',$fill);
	$pdf->Cell($w[4],5.5,$apps->date_to,'LR',0,'R',$fill);
	$pdf->Cell($w[4],5.5,$apps->application_date,'LR',0,'R',$fill);
    $pdf->Ln();	
	$fill = !$fill;	
    // Closing line

$no++;
 
endforeach;
$pdf->Cell(array_sum($w),0,'','T');   


}



//------------------------report 2

else if(isset($_POST['report2'])){
$staff_id=$_POST['staff_id'];
$staff=Staff::find_by_staff_id($staff_id);

$apps_mine=Applications::find_my_applications($staff_id);

$dept=Department::find_by_department_id($staff->department_id);
$pdf->Cell(0,10,'STAFF: '.$staff->first_name ." ".$staff->last_name,0,1,'A'); 
$pdf->Cell(0,10,'DEPARTMENT: '. $dept->department_name,0,1,'A');

$pdf->SetLineWidth(.3);
$pdf->SetFont('','B');
    // Header
$w = array(10,50, 50, 50, 30);
	$header = array('#','NAME', 'START DATE', 'END DATE', 'STATUS');
	
	//pages separator.
	$pdf->Cell(11,10,'',0,2);
	
    for($i=0;$i<count($header);$i++)
       $pdf->Cell($w[$i],7,$header[$i],1,0);
   $pdf->Ln();
    // Color and font restoration
   $pdf->SetFillColor(224,235,255);
   $pdf->SetTextColor(0);
   $pdf->SetFont('','','B');
    // Data
    $fill = false;
   

foreach($apps_mine as $applications):

$leave=Leave::find_by_leave_id($applications->leave_id);

    $pdf->Cell($w[0],5.5,$no,'LR',0,'L',$fill);
	$pdf->Cell($w[1],5.5,$leave->leave_name,'LR',0,'L',$fill);
    $pdf->Cell($w[2],5.5,$applications->date_from,'LR',0,'L',$fill);
    $pdf->Cell($w[3],5.5,$applications->date_to,'LR',0,'LR',$fill);
	$pdf->Cell($w[4],5.5,$applications->status,'LR',0,'R',$fill);
    $pdf->Ln();
    $fill = !$fill;	
    // Closing line

$no++;
 
endforeach;
$pdf->Cell(array_sum($w),0,'','T');
}

//-------------------REPORT 3-----------------------------------

else{


$today=date('Y-m-d');
$on_leave=Applications::find_applicants_on_leave($today);
$pdf->SetLineWidth(.3);
$pdf->SetFont('','B');
    // Header
$w = array(7,30,30,30,30,30);
	$header = array('#','NAME','LEAVE','START DATE','END DATE','STATUS');
	
	//pages separator.
	$pdf->Cell(11,10,'',0,2);
	
    for($i=0;$i<count($header);$i++)
       $pdf->Cell($w[$i],7,$header[$i],1,0);
   $pdf->Ln();
    // Color and font restoration
   $pdf->SetFillColor(224,235,255);
   $pdf->SetTextColor(0);
   $pdf->SetFont('','','B');
    // Data
    $fill = false;
   

foreach($on_leave as $applications):

$leave=Leave::find_by_leave_id($applications->leave_id);
$staff=Staff::find_by_staff_id($applications->staff_id);
    $pdf->Cell($w[0],5.5,$no,'LR',0,'L',$fill);
	$pdf->Cell($w[1],5.5,$staff->first_name ." ". $staff->last_name,'LR',0,'L',$fill);
	$pdf->Cell($w[1],5.5,$leave->leave_name,'LR',0,'L',$fill);
    $pdf->Cell($w[2],5.5,$applications->date_from,'LR',0,'L',$fill);
    $pdf->Cell($w[3],5.5,$applications->date_to,'LR',0,'LR',$fill);
	$pdf->Cell($w[4],5.5,$applications->status,'LR',0,'R',$fill);
    $pdf->Ln();
    $fill = !$fill;	
    // Closing line

$no++;
 
endforeach;
$pdf->Cell(array_sum($w),0,'','T');

}






$pdf->Output();


?>