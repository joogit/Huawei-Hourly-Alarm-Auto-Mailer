<?php
ini_set("memory_limit", "1000M");
set_time_limit(0);	
date_default_timezone_set('Asia/Dhaka');

include 'include/db.php';

$del_table = mysql_query("TRUNCATE TABLE hdata");

mysql_query("SET CHARACTER SET utf8");
mysql_query("SET SESSION collation_connection =utf8_general_ci"); 

$date = date("Ymd", time());
$file_name="alarm.csv";
$file_path="raw_files/M2K1/NBI_FM/".$date."/".$file_name;
$file = fopen("$file_path","r");

$content=fgetcsv($file);


while (!feof($file))
{
    $content=fgetcsv($file);
    mysql_query("INSERT INTO hdata VALUES ('$content[1]','$content[4]','$content[6]','$content[8]','$content[9]','$content[10]','$content[11]','$content[12]','$content[14]','$content[17]','$content[22]')");

}

//2nd part
$date = date("Ymd", time());
$file_name="alarm_2.csv";
$file_path="raw_files/M2K1/NBI_FM/".$date."/".$file_name;
if (file_exists($file_path))
{
    $file = fopen("$file_path","r");


    $content=fgetcsv($file);


    while (!feof($file))
    {
        $content=fgetcsv($file);
        mysql_query("INSERT INTO hdata VALUES ('$content[1]','$content[4]','$content[6]','$content[8]','$content[9]','$content[10]','$content[11]','$content[12]','$content[14]','$content[17]','$content[22]')");

    }
}


//3rd part
$date = date("Ymd", time());
$file_name="alarm_3.csv";
$file_path="raw_files/M2K1/NBI_FM/".$date."/".$file_name;
if (file_exists($file_path))
{
    $file = fopen("$file_path","r");


    $content=fgetcsv($file);


    while (!feof($file))
    {
        $content=fgetcsv($file);
        mysql_query("INSERT INTO hdata VALUES ('$content[1]','$content[4]','$content[6]','$content[8]','$content[9]','$content[10]','$content[11]','$content[12]','$content[14]','$content[17]','$content[22]')");

    }
}

//4th part

$date = date("Ymd", time());
$file_name="alarm.csv";
$file_path="raw_files/M2K2/NBI_FM/".$date."/".$file_name;
$file = fopen("$file_path","r");

$content=fgetcsv($file);


while (!feof($file))
{
    $content=fgetcsv($file);
    mysql_query("INSERT INTO hdata VALUES ('$content[1]','$content[4]','$content[6]','$content[8]','$content[9]','$content[10]','$content[11]','$content[12]','$content[14]','$content[17]','$content[22]')");

}


//5th part

$date = date("Ymd", time());
$file_name="alarm_2.csv";
$file_path="raw_files/M2K2/NBI_FM/".$date."/".$file_name;

if (file_exists($file_path)) 
{

    $file = fopen("$file_path","r");

    $content=fgetcsv($file);


    while (!feof($file))
    {
        $content=fgetcsv($file);
        mysql_query("INSERT INTO hdata VALUES ('$content[1]','$content[4]','$content[6]','$content[8]','$content[9]','$content[10]','$content[11]','$content[12]','$content[14]','$content[17]','$content[22]')");

    }
}

//6th part

$date = date("Ymd", time());
$file_name="alarm_3.csv";
$file_path="raw_files/M2K2/NBI_FM/".$date."/".$file_name;

if (file_exists($file_path)) 
{

    $file = fopen("$file_path","r");

    $content=fgetcsv($file);


    while (!feof($file))
    {
        $content=fgetcsv($file);
        mysql_query("INSERT INTO hdata VALUES ('$content[1]','$content[4]','$content[6]','$content[8]','$content[9]','$content[10]','$content[11]','$content[12]','$content[14]','$content[17]','$content[22]')");

    }
}


//7th part

$date = date("Ymd", time());
$file_name="alarm.csv";
$file_path="raw_files/M2K3/NBI_FM/".$date."/".$file_name;

if (file_exists($file_path)) 
{

    $file = fopen("$file_path","r");

    $content=fgetcsv($file);


    while (!feof($file))
    {
        $content=fgetcsv($file);
        mysql_query("INSERT INTO hdata VALUES ('$content[1]','$content[4]','$content[6]','$content[8]','$content[9]','$content[10]','$content[11]','$content[12]','$content[14]','$content[17]','$content[22]')");

    }
}

//8th part
$date = date("Ymd", time());
$file_name="alarm_1.csv";
$file_path="raw_files/M2K3/NBI_FM/".$date."/".$file_name;

if (file_exists($file_path)) 
{

    $file = fopen("$file_path","r");

    $content=fgetcsv($file);


    while (!feof($file))
    {
        $content=fgetcsv($file);
        mysql_query("INSERT INTO hdata VALUES ('$content[1]','$content[4]','$content[6]','$content[8]','$content[9]','$content[10]','$content[11]','$content[12]','$content[14]','$content[17]','$content[22]')");

    }
}



?>