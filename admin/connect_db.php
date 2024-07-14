<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "doan";
$con = mysqli_connect($host, $user, $password, $database, 3306);
$con -> set_charset('utf8');
mysqli_query($con,"set time_zone='+07:00'");
if (mysqli_connect_errno()) {
    echo "Connection Fail: " . mysqli_connect_errno();
    exit;
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

