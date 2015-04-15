<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$path = '../../../includes.php';

if(file_exists($path)){
    include('../../../includes.php');
}

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select("*");
$query->from("#__counter");

$db->setQuery($query);
$row = $db->loadObject();

echo $row->count;