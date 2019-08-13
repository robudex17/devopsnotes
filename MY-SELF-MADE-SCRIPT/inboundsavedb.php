<?php

$extension = $argv[1];
$option = $argv[2];
$logdate = $argv[3];
$logtime = $argv[4];

if ($option == "1") {
		$log = "IN";
}elseif ($option == "0") {
	$log = "OUT";
}


$servername = "103.5.6.2";
$servername2 = "210.1.86.210";
$username = "python";
$password = "sbtph@2018";
$dbname = "sbtphcsd";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
   //USE BACK IS INCASE PRIMARY IS DOWN
   $conn = new mysqli($servername2, $username, $password, $dbname);
   if($conn->connect_error) {
	   die("Connection failed: " . $conn->connect_error);
   }
}else {
	echo "good"; 
	echo $log;
	echo $extension;
	echo $option;
} 

$sqlupdate = "UPDATE  `csdinbound` SET receive_calls ='$option' WHERE `extension`= '$extension'";
//$sql = "UPDATE `extension_group` SET tme$row[id]='$bit' WHERE `group`='$group'";

$resultupdate = $conn->query($sqlupdate);

if($conn->query($sqlupdate)=== TRUE){
	echo "Record updated successfully";
}else{
	echo "Error updating record: ". $conn->error;
}

$sqlinsert = "INSERT INTO `logs` (extension,log,logdate,logtime) VALUES ('$extension','$log','$logdate','$logtime') ";

$resulinsert = $conn->query($sqlinsert);

$conn->close();


?>
