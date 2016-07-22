<?php
    $host = '10.10.91.23';
    $username = 'root';
    $password = '';
    $db = 'aska_db_test';
    $res = mysql_connect($host, $username, $password);
    if (!$res)
        die('Could not connect to the server, mysql error: ' . mysql_error($res));
    $res = mysql_select_db($db);
    if (!$res)
        die('Could not connect to the database, mysql error: ' . mysql_error($res));
?>