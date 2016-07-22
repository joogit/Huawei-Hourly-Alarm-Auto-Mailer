<?php
date_default_timezone_set('Asia/Dhaka');

include 'include/db.php';

$date = date("d/m/y", time());	


//2nd E1 down

$query="Select Object_Name,Location_Info,OccurrenceTime from hdata where  AlarmID = '25801' AND Location_Info Not like '%Port No.=0%' AND ClearanceTime ='' ";
$result=mysql_query($query);


//==================================================================================================================================================================================					
$Subject = $date."_Abis E1 Down Notification";

//Defining the E-mail body:			
$EmailBody = '<html>';
$EmailBody .= '<body>';
$EmailBody .= 'Dear Concern,'."<br/><br/>".'Abis E1 down info update::'."<br/><br/><font color=Blue>".""."</font>";			
$EmailBody .= '<table cellpadding="3">';


//2nd/3rd E1 down issue sql
$EmailBody .= "<table><tr><td valign='top'>";	

if(mysql_num_rows($result)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='5'><font color='ffffff'> :: Abis E1 down Alarm info::</font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>Site</strong></td><td><strong><center>Details</center></strong></td><td><strong>Occurance time</strong></td><tr>";
    while($rowsql=mysql_fetch_assoc($result)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql['Object_Name']."</td><td><center>".$rowsql['Location_Info']."</center></td><td><center>".$rowsql['OccurrenceTime']."</center></td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{
    $EmailBody .= "<p style='font-family:verdana; font-size=0.6em; background: #1BE042; '><font color='black'> No Abis E1 down </font></p>";

}
              
$EmailBody .= "</td></tr></table>";



$EmailBody .= "</td></tr></table>";


$EmailBody .= "<br/><br/>"."This is an Auto-Generated Alarm Notification."."<br/>".".........................................."."<br/>"."OMC BSS, Banglalink"."<br/>"."..........................................";			
$EmailBody .= "</body></html>";


//$EmailBody= 'asdfasd';
//==================================================================================================================================================================================		

include "include/class.phpmailer.php";
$mail = new PHPMailer();
$mail->SetLanguage("en", "/mail/language/");

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "172.16.10.170";  // specify main and backup server
$mail->SMTPAuth = false; // turn on SMTP authentication
$mail->Username = "";   // SMTP username
$mail->Password = "";  // SMTP password

$mail->From = "no-reply@banglalinkgsm.com";
//$mail->From = $email_to2;
$mail->FromName = "Alarm Notification";
$email_test="omc_bss@banglalinkgsm.com";
if ( $email_test != '') { $mail->AddAddress( $email_test, "");}						


$email_to="OMC_BSS@banglalinkgsm.com";	
$CC12 = "mfahad@banglalinkgsm.com";

if ( $email_to != '') { $mail->AddAddress( $email_to, "");}
if ( $email_to1 != '') { $mail->AddAddress( $email_to1, "");}
if ( $email_to2 != '') { $mail->AddAddress( $email_to2, "");}						
if ( $CC1 != '') { $mail->AddCC( $CC1, "");}
if ( $CC2 != '') { $mail->AddCC( $CC2, "");}
if ( $CC3 != '') { $mail->AddCC( $CC3, "");}						
if ( $CC12 != '') { $mail->AddCC( $CC12, "");}											


$mail->WordWrap = 50;                                 // set word wrap to 50 characters
$mail->AddAttachment($path);    // optional name
$mail->IsHTML(true);                                  // set email format to HTML
$mail->Subject = $Subject;
$mail->Body    = $EmailBody."<br>";
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