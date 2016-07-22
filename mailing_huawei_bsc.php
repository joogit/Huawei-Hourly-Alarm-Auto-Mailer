<?php
date_default_timezone_set('Asia/Dhaka');

include 'include/db.php';

$date = date("d/m/y", time());	


//for Site down

$query="SELECT Object_Name As site,Count(*) As count from hdata where  AlarmName like '%LAPD OML Fault%' GROUP BY Object_Name ORDER BY COUNT(*) DESC";
$result=mysql_query($query);


//for cell down
$query1="select MID(Object_Name,7,11) AS Cell_Name, COUNT(MID(Object_Name,7,11)) AS count from hdata where AlarmName like '%Cell Out of Service%' GROUP BY MID(Object_Name,7,11) ORDER BY COUNT(MID(Object_Name,7,11)) DESC";
$result1=mysql_query($query1);


//For Board fault
$query2="select AlarmName,AlarmSource,Location_Info,OccurrenceTime,ClearanceTime from hdata where  AlarmName like '%Board% %fault%' AND (AlarmSource NOT LIKE '%\_U%' AND AlarmSource NOT LIKE '%\_V%' AND Location_Info NOT LIKE '%UPEU%' AND Location_Info NOT LIKE '%Site%')";

$result2=mysql_query($query2);


//NE Disconnect 	
$query3="select AlarmName,Object_Name,Location_Info,OccurrenceTime,ClearanceTime from hdata where  (AlarmName like '%NE Is Disconnected%') AND Location_Info NOT LIKE '%neIP=NULL%'";
$result3=mysql_query($query3);



//query for E1/T1 Alarm for sites

$query4="SELECT AlarmSource,COUNT(AlarmSource) AS COUNT from hdata where (AlarmName like '%E1/T1%' AND Location_Info not like '% BS%') GROUP BY AlarmSource ORDER BY COUNT(AlarmSource) DESC";
$result4=mysql_query($query4);



//query for E1/T1 Alarm for BSC

$query5="SELECT AlarmSource,COUNT(AlarmSource) AS COUNT from hdata where (AlarmName like '%E1/T1%' AND Location_Info like '% BS%') GROUP BY AlarmSource ORDER BY COUNT(AlarmSource) DESC";
$result5=mysql_query($query5);

$query6="select AlarmSource as NodeB,COUNT(AlarmSource) AS count from hdata where AlarmName like '%SCTP Link Fault%' AND Severity='Major' GROUP BY AlarmSource ORDER BY COUNT(AlarmSource) DESC";
$result6=mysql_query($query6);


//Details E1/T1 Alarm for BSC

$query7="SELECT AlarmSource,Location_Info,AlarmName from hdata where (AlarmName like '%E1/T1%' AND Location_Info like '% BS%') GROUP BY AlarmSource ORDER BY AlarmName DESC";
$result7=mysql_query($query7);


//License alarm

$query8="select AlarmName,Object_Name,Location_Info,OccurrenceTime,ClearanceTime from hdata where (AlarmName like '%License%' AND (Object_Name NOT LIKE '%\_U%' AND Object_Name NOT LIKE '%\_V%'))";
$result8=mysql_query($query8);


//6910 M3UA alarm

$query9="SELECT AlarmName,AlarmSource,Location_Info,OccurrenceTime,ClearanceTime from hdata where AlarmID='21552'";
$result9=mysql_query($query9);


//Adjacent Node IP Address Ping Failure

$query10="SELECT Object_Name as RNC,Count(*) as Count from hdata where AlarmID='21392' GROUP BY Object_Name ORDER BY COUNT(*) DESC";
$result10=mysql_query($query10);


//==================================================================================================================================================================================					
$Subject = $date."_Alarm Notification for Huawei Network";

//Defining the E-mail body:			
$EmailBody = '<html>';
$EmailBody .= '<body>';
$EmailBody .= 'Dear Concern,'."<br/><br/>".'Please take necessary actions for the below alarms:'."<br/><br/><font color=Blue>".""."</font>";			
$EmailBody .= '<table cellpadding="3">';


//BSC License sql8
$EmailBody .= "<table><tr><td valign='top'>";	

if(mysql_num_rows($result8)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='5'><font color='ffffff'> :: License expiration alarm ::</font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>Alarm name</strong></td><td><strong>Alarm Source</strong></td><td><strong>Location info</strong></td><td><strong>Occurance time</strong></td><td><strong>Clearance time</strong></td><tr>";
    while($rowsql8=mysql_fetch_assoc($result8)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql8['AlarmName']."</td><td><center>".$rowsql8['Object_Name']."</center></td><td><center>".$rowsql8['Location_Info']."</center></td><td><center>".$rowsql8['OccurrenceTime']."</center></td><td><center>".$rowsql8['ClearanceTime']."</center></td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{

}

$EmailBody .= "</td></tr></table>";


//6910 M3UA alarm sql9
$EmailBody .= "<table><tr><td valign='top'>";	

if(mysql_num_rows($result9)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='5'><font color='ffffff'> :: 6910 M3UA alarm ::</font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>Alarm name</strong></td><td><strong>Alarm Source</strong></td><td><strong>Location info</strong></td><td><strong>Occurance time</strong></td><td><strong>Clearance time</strong></td><tr>";
    while($rowsql9=mysql_fetch_assoc($result9)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql9['AlarmName']."</td><td><center>".$rowsql9['AlarmSource']."</center></td><td><center>".$rowsql9['Location_Info']."</center></td><td><center>".$rowsql9['OccurrenceTime']."</center></td><td><center>".$rowsql9['ClearanceTime']."</center></td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{

}

$EmailBody .= "</td></tr></table>";


//BSC Board fault sql2
$EmailBody .= "<table><tr><td valign='top'>";	

if(mysql_num_rows($result2)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='5'><font color='ffffff'> :: BSC Board fault ::</font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>Alarm name</strong></td><td><strong>Alarm Source</strong></td><td><strong>Location info</strong></td><td><strong>Occurance time</strong></td><td><strong>Clearance time</strong></td><tr>";
    while($rowsql2=mysql_fetch_assoc($result2)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql2['AlarmName']."</td><td><center>".$rowsql2['AlarmSource']."</center></td><td><center>".$rowsql2['Location_Info']."</center></td><td><center>".$rowsql2['OccurrenceTime']."</center></td><td><center>".$rowsql2['ClearanceTime']."</center></td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{
    $EmailBody .= "<p style='font-family:verdana; font-size=0.6em; background: #90EE90; '><font color='black'> No BSC Board Fault Alarm. </font></p>";
}

$EmailBody .= "</td></tr></table>";


//NE Disconnect alarm sql3

$EmailBody .= "<table><tr><td valign='top'>";	

if(mysql_num_rows($result3)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='5'><font color='ffffff'> :: OMC Connection Failure Alarm ::</font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>Alarm name</strong></td><td><strong>Object Name</strong></td><td><strong>Location info</strong></td><td><strong>Occurance time</strong></td><td><strong>Clearance time</strong></td><tr>";
    while($rowsql3=mysql_fetch_assoc($result3)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql3['AlarmName']."</td><td><center>".$rowsql3['Object_Name']."</center></td><td><center>".$rowsql3['Location_Info']."</center></td><td><center>".$rowsql3['OccurrenceTime']."</center></td><td><center>".$rowsql3['ClearanceTime']."</center></td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{
    $EmailBody .= "<p style='font-family:verdana; font-size=0.6em; background: #90EE90; '><font color='black'> No OMC Connection Failure Alarm. </font></p>";
}

$EmailBody .= "</td></tr></table>";


//For LAPD OML fault sql

$EmailBody .= "<table><tr><td valign='top'>";
$EmailBody .= '<table style="font-family:verdana; border: #000;" cellpadding="3">';
$EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='2'><font color='ffffff'> :: 2G BTS Fluctuation ::</font></th></tr>";			
$EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>Site Name</strong></td><td><strong>No of Occurence</strong></td></tr>";						
while(($rowsql=mysql_fetch_assoc($result)) && ($rowsql['count']) > 1 ) {
    $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql['site']."</td><td><center>".$rowsql['count']."</center></td></tr>";
}
; 
$EmailBody .= "</table>";

$EmailBody .= "</td><td valign='top'>";	


//Node B down sql6

if(mysql_num_rows($result6)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #000;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='2'><font color='ffffff'> :: 3G NodeB Fluctuation :: </font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><th><strong>NodeB Name</strong></th><th><strong>No of Occurence</strong></th></tr>";
    while($rowsql6=mysql_fetch_assoc($result6)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql6['NodeB']."</td><td><center>".$rowsql6['count']."</center></td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{
    $EmailBody .= "<p style='font-family:verdana; font-size=0.6em; background: #90EE90; '><font color='black'> No NodeB Fluctuation </font></p>";
}

$EmailBody .= "</td></tr></table>";


//for E1/T1 alarm in BSC sql5	

$EmailBody .= "<table><tr><td valign='top'>";	

if(mysql_num_rows($result5)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='2'><font color='ffffff'> ::E1/T1 Alarms against BSC*:: </font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>BSC name</strong></td><td><strong>No of Occurence</strong></td><tr>";
    while($rowsql5=mysql_fetch_assoc($result5)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql5['AlarmSource']."</td><td>".$rowsql5['COUNT']."</td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{
    $EmailBody .= "<p style='font-family:verdana; font-size=0.6em; background: #90EE90; '><font color='black'> No E1/T1 Alarms against BSC* </font></p>";
}


$EmailBody .= "</td><td valign='top'>";	


if(mysql_num_rows($result4)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='2'><font color='ffffff'> ::E1/T1 Alarms against BTS:: </font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><strong>BSC name</strong></td><td><strong>No of Occurence</strong></td></tr>";
    while(($rowsql4=mysql_fetch_assoc($result4)) && ($rowsql4['COUNT']) > 5 ) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql4['AlarmSource']."</td><td>".$rowsql4['COUNT']."</td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{
    $EmailBody .= "<p style='font-family:verdana; font-size=0.6em; background: #90EE90; '><font color='black'> No E1/T1 Alarms against BTS</font></p>";
}

$EmailBody .= "</td></tr></table>";

//Details E1/T1 alarm in BSC sql7	

$EmailBody .= "<table><tr><td valign='top'>";	

if(mysql_num_rows($result7)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #666;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='5'><font color='ffffff'> ::*E1/T1 Alarms against BSC:: </font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><td><strong>Alarm Source</strong></td><td><strong>Location info</strong></td><td><strong>Alarm name</strong></td><tr>";
    while($rowsql7=mysql_fetch_assoc($result7)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql7['AlarmSource']."</td><td>".$rowsql7['Location_Info']."</td><td>".$rowsql7['AlarmName']."</td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{
}



$EmailBody .= "</td></tr></table>";	


//Adjacent Node IP Address Ping Failure

$EmailBody .= "<table><tr><td valign='top'>";	

if(mysql_num_rows($result10)!=0){		
    $EmailBody .= '<table style="font-family:verdana; border-color: #000;" cellpadding="3">';
    $EmailBody .= "<tr style='font-family:verdana; background: #66CDAA;'><th colspan='2'><font color='ffffff'> :: Adjacent Node IP Address Ping Failure Alarm :: </font></th></tr>";
    $EmailBody .= "<tr style='font-family:verdana; background: #E0FFFF;'><th><strong>RNC Name</strong></th><th><strong>No of Occurence</strong></th></tr>";
    while($rowsql10=mysql_fetch_assoc($result10)) {
        $EmailBody .="<tr style='font-family:verdana; background: #E6E6FA;'><td>".$rowsql10['RNC']."</td><td><center>".$rowsql10['Count']."</center></td></tr>";
    }
    ;
    $EmailBody .= "</table>";
}
else{
    $EmailBody .= "<p style='font-family:verdana; font-size=0.6em; background: #90EE90; '><font color='black'> No Adjacent Node IP Address Ping Failure </font></p>";
}

$EmailBody .= "</td></tr></table>";

$EmailBody .= "<br/><br/>"."Best Regards,"."<br/>"."OMC BSS, Banglalink"."<br/>"."+88 019 15000739"."<br/>"."Powered By: <b><a href=''>ASKA-NetDiag</a></b>";			
$EmailBody .= "</body></html>";

//==================================================================================================================================================================================		

include "include/class.phpmailer.php";

$mail = new PHPMailer();
$mail->SetLanguage("en", "/mail/language/");

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "172.16.10.170";  // specify main and backup server
$mail->SMTPAuth = false; // turn on SMTP authentication
$mail->Username = "";   // SMTP username
$mail->Password = "";  // SMTP password

$mail->From = "omc_bss@banglalinkgsm.com";
$mail->FromName = "OMC BSS";
$email_test="OMC_BSS@banglalinkgsm.com";
if ( $email_test != '') { $mail->AddAddress( $email_test, "");}						


$email_to="supervision@banglalinkgsm.com";	

$CC2 = "assarker@banglalinkgsm.com";
$CC3 = "ijamil@banglalinkgsm.com";
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