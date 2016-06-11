<?php
$db_name = "spider16task2";
$mysql_username = "root";
$mysql_password = "";
$server_name = "localhost";
$conn = mysqli_connect($server_name,$mysql_username,$mysql_password,$db_name);
if(!$conn)
{
echo "connection not success";
}
/*else
{
echo "connection not success";
}*/
?>