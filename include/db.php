<?php
    $host = '';
    $username = '';
    $password = '';
    $db = '';
    $res = mysql_connect($host, $username, $password);
    if (!$res)
        die('Could not connect to the server, mysql error: ' . mysql_error($res));
    $res = mysql_select_db($db);
    if (!$res)
        die('Could not connect to the database, mysql error: ' . mysql_error($res));
?>