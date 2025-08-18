<?php
//db connection here......
$host_name="localhost";
$user="u406436799_Devoutgrowth25";
$pass="Devout-growth@#25";
$db="u406436799_dg_panel";
$conn=mysqli_connect($host_name,$user,$pass,$db);
if(!$conn){
die("db connection failed:".mysqli_connect_error());
}
//echo "connection established";
?>