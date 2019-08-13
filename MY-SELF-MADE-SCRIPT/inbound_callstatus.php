#!/usr/bin/php -q

<?php
$myServer = "103.5.6.2";
$myUser = "python";
$myPass = "sbtph@2018";
$myDB = "sbtphcsd";

$vStartTimeStamp = $argv[1];
$vEndTimeStamp = $argv[2];
$vCallStatus = $argv[3];
$vCaller = $argv[4];
$vCalledNumber = $argv[5];
$vWhoAnsweredCall = $argv[6];

if($vWhoAnsweredCall != "NONE" && ($vCalledNumber == "2909485" || $vCalledNumber == "9035031733" || $vCalledNumber == "923136601666" || $vCalledNumber == "0452909485")){
	$pieces = explode("/", $vWhoAnsweredCall);
	$vWhoAnsweredCall = $pieces[1];
}
 $getCurrentdate = date('Y-m-d');

// Create connection
$conn = new mysqli($myServer, $myUser, $myPass, $myDB);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else {
	echo "Connected..."; 
} 


$query = "INSERT INTO inbound_callstatus";
$query .= "(StartTimeStamp, EndTimeStamp, CallStatus, Caller, CalledNumber, WhoAnsweredCall,getDate) VALUES ";
$query .= "('".$vStartTimeStamp."','".$vEndTimeStamp."','".$vCallStatus."','".$vCaller."','".$vCalledNumber."','".$vWhoAnsweredCall."','".$getCurrentdate."')";


$result = $conn->query($query);

if(!$result){
	echo("Error description: " . mysqli_error($conn));

}else{
	echo "success";
}
$conn->close();




?>


