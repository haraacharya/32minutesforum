<?php  
//connect.php  
//$server = 'haraacharya.ipagemysql.com';  
//$username   = '32minutesadmin';  
//$password   = '32minutes@123';  
//$database   = '32minutes';  

$server = 'localhost';  
$username   = 'root';  
$password   = '';  
$database   = '30minutes';  

if(!mysql_connect($server, $username,  $password))  
{  
    die('Could not connect: ' . mysql_error()); 
}  
if(!mysql_select_db($database))  
{  
    exit('Error: could not select the database');  
}  
?>  

