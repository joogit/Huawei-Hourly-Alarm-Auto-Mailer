<?php
date_default_timezone_set('Asia/Dhaka');

include 'include/db.php';

$date = date("d/m/y", time());	

//Total count

$query="SELECT COUNT(*) as total FROM hdata where AlarmID='21802' AND (Location_Info like '%SYL_G0418%' or Location_Info like '%SYL_X0553%' or Location_Info like '%SYL_G0394%' or Location_Info like '%SYL_X0554%' or Location_Info like '%CTG_G1233%' or Location_Info like '%SYL_G0622%' or Location_Info like '%CTG_X1535%' or Location_Info like '%CTG_X1554%' or Location_Info like '%SYL_G0419%' or Location_Info like '%CTG_G1290%' or Location_Info like '%CTG_X1313%' or Location_Info like '%CTG_X1503%')";
$result=mysql_query($query);

//details

$query1="SELECT Object_Name as site, Location_Info as info,OccurrenceTime,ClearanceTime FROM hdata where AlarmID='21802' AND (Location_Info like '%SYL_G0418%' or Location_Info like '%SYL_X0553%' or Location_Info like '%SYL_G0394%' or Location_Info like '%SYL_X0554%' or Location_Info like '%CTG_G1233%' or Location_Info like '%SYL_G0622%' or Location_Info like '%CTG_X1535%' or Location_Info like '%CTG_X1554%' or Location_Info like '%SYL_G0419%' or Location_Info like '%CTG_G1290%' or Location_Info like '%CTG_X1313%' or Location_Info like '%CTG_X1503%') AND ClearanceTime =' '";
$result1=mysql_query($query1);


//==================================================================================================================================================================================					
$Subject = $date."_Special_lock-unlock";

//Defining the E-mail body:			
$EmailBody = '<html>';
$EmailBody .= '<body>';
$EmailBody .= 'FYI,'."<br/><br/>".'Auto Lock-Unlock::'."<br/><br/><font color=Blue>".""."</font>";			
$EmailBody .= '<table cellpadding="3">';


//Total count sql
$EmailBody .= "<table><tr><td valign='top'>";	


$EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
$EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='5'><font color='ffffff'> :: Total count ::</font></th></tr>";			
$EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>Total occurance</strong></td></tr>";						
while($rowsql=mysql_fetch_assoc($result)) {
    $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql['total']."</td></tr>";
}
; 
$EmailBody .= "</table>";


$EmailBody .= "</td></tr></table>";



//details sql1
$EmailBody .= "<table><tr><td valign='top'>";	

if(mysql_num_rows($result1)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='5'><font color='ffffff'> :: Details::</font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>Site</strong></td><td><strong><center>Details</center></strong></td><td><strong>Occurance time</strong></td><td><strong><center>Clearance Time</center></strong></td></tr>";
    while($rowsql1=mysql_fetch_assoc($result1)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql1['site']."</td><td><center>".$rowsql1['info']."</center></td><td><center>".$rowsql1['OccurrenceTime']."</center></td><td><center>".$rowsql1['ClearanceTime']."</center></td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{

}

$EmailBody .= "</td></tr></table>";




$EmailBody .= "<br/><br/>"."This is an Auto-Generated Alarm Notification."."<br/>".".........................................."."<br/>"."OMC BSS, Banglalink"."<br/>"."..........................................";			
$EmailBody .= "</body></html>";


//==================================================================================================================================================================================		


include "Emailing/mail2/mail/class.phpmailer.php";	
//include("./mail/class.phpmailer.php");
$mail = new PHPMailer();
$mail->SetLanguage("en", "/mail/language/");

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "172.16.10.170";  // specify main and backup server
$mail->SMTPAuth = false; // turn on SMTP authentication
$mail->Username = "";   // SMTP username
$mail->Password = "";  // SMTP password

$mail->From = "no-reply@banglalinkgsm.com";
$mail->FromName = "Alarm Notification";
$email_test="Sali@banglalinkgsm.com";
if ( $email_test != '') { $mail->AddAddress( $email_test, "");}						


$email_to="mfahad@banglalinkgsm.com";	
if ( $CC1 != '') { $mail->AddCC( $CC1, "");}
if ( $CC2 != '') { $mail->AddCC( $CC2, "");}
if ( $CC3 != '') { $mail->AddCC( $CC3, "");}						
if ( $CC12 != '') { $mail->AddCC( $CC12, "");}											


$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->AddAttachment($path);    // optional name
$mail->IsHTML(true);                                  // set email format to HTML
$mail->Subject = $Subject;
$mail->Body    = $EmailBody."<br>";
//$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
if(!$mail->Send())
{
    echo "E-mail could not be sent. <p>";
    echo "Mailer Error: " . $mail->ErrorInfo;
    exit;
}

else
{
    echo "<h1>Please fill up the EmailBody field !!!</h1>";
}
//====================================================================================================