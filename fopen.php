<?php
if($_POST['count']){
    $of = $_POST['of'];
    $to = $_POST['to'];
    $count = $_POST['count'];
    
    $fp = fopen('counter.txt', 'w');
    fwrite($fp, "$of\r\n");
    fwrite($fp, "$to\r\n");
    fwrite($fp, $count);
    fclose($fp);
}