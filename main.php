<?php

function explodeTrim($string){
    $array = explode("│", $string);

    foreach($array as $key=>$value){
        $array[$key] = trim ($value);
    }
    return $array;
}

function getDuration($string){
    list($hours, $minutes, $seconds) = explode(':', $string);
    list($seconds, $milliseconds) = explode('.', $seconds);
    return (($hours * 60 + $minutes) * 60 + $seconds) * 1000 + $milliseconds;
}

function  insertIdlx($string) {
    $db = new SQLite3('LogTopSql.db');

    $array = explodeTrim($string);
    if (count($array) <= 23) return;
    if (strlen($array[2]) < 12) return;
    echo $array[2];
    $date = (new DateTime($array[2]))->format('Y-m-d');
    $time = (new DateTime($array[2]))->format('H:i:s');
    $query = $array[22];
    $pid = $array[6];
    $duration = getDuration($array[3]);

    $sql = "INSERT INTO idlx (date, \"query\", pid, time, sended, duration) VALUES('{$date}' , '{$query}', {$pid}, '{$time}', 0, {$duration});";

    try {
        $result = $db->query($sql);
    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
    }
    $db->close();
    return $result;
}

function  insertSlowQuery($string) {
    $db = new SQLite3('LogTopSql.db');

    $array = explodeTrim($string);
    if (count($array) <= 23) return;
    if (strlen($array[2]) < 12) return;
    $date = (new DateTime($array[2]))->format('Y-m-d');
    $time = (new DateTime($array[2]))->format('H:i:s');
    $query = $array[22];
    $pid = $array[6];
    $duration = getDuration($array[3]);

    $sql = "INSERT INTO sqlowquery (date, \"query\", pid, time, sended, duration) VALUES('{$date}', '{$query}', {$pid}, '{$time}', 0, {$duration});";

    try {
        $result = $db->query($sql);
    } catch (Exception $e) {
        echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
    }
    $db->close();
    return $result;
}

function getFiles($type = 0){
    $mask = 'E:\\Workspace\\LogTopSqlParser\\logs\\Kill 3 min*.log';
    if ($type == 1) {
        $mask = 'E:\\Workspace\\LogTopSqlParser\\logs\\Kill 10 min*.log';
    }

    return glob($mask);
}

foreach (getFiles(1) as $file) {
    echo $file, "\n";
    $handle = @fopen($file, "r");
    while (($string = fgets($handle)) !== false) {
        insertSlowQuery($string);
    }

    fclose($handle);

    unlink($file);
}

foreach (getFiles() as $file) {
    echo $file, "\n";
    $handle = @fopen($file, "r");
    while (($string = fgets($handle)) !== false) {
        insertIdlx($string);
    }

    fclose($handle);

    unlink($file);
}





