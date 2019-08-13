
<?php
$servername = "localhost";
$username = "sbtph";
$password = "sbtph@2017db";
$dbname = "sbtphsales";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM agents ORDER BY Total_Sales DESC";
$result = $conn->query($sql);
?>
<html>
<style>
body {
    background-color: lightblue;
}

h1 {
    color: white;
    text-align: center;
}

p {
    font-family: verdana;
    font-size: 20px;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th {
	font-size: 60px;
	color: red;
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th, td {
	font-size: 50px;
    padding: 8px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}
</style>

<body>
 <?php
  
$result = $conn->query($sql_active );
if ($result->num_rows > 0){
	?>
	<h1 >GOT NEW SALES!!!</h1>

	<table>
   
  <tr>
  
    <th>Name</th> 
    <th>Sales</th>
  </tr>
  
<?php

  while($row = $result->fetch_assoc()) {
	   
       echo "<tr>";
	   echo "<td>".$row['Name']. "</td>";
	   echo "<td>".$row['new_sales']. "</td>";
	   echo "</tr>";
	   usleep(5000000);
	   $id= $row['id'];
	    $new_sales= $row['new_sales'];
	    $sql = "SELECT Total_Sales FROM agents where id = $id";
	   
	   $result1 = $conn->query($sql);
	    while($row1 = $result1->fetch_assoc()){
	      $total_sales = $row1['Total_Sales'] + $new_sales;
		
		  $sql = "UPDATE agents SET Total_Sales = $total_sales  where id = $id";
		  $result1 = $conn->query($sql);
		  
		  $sql = "UPDATE active_sales SET new_sales = 0 where id = $id";
		  $result1 = $conn->query($sql);
	   }
    }

  exit;
}else {
	
?>	

<table >

  <tr>
    <th>Rank</th>
    <th>Name</th> 
    <th>Total Sales</th>
  </tr>
  	<?php
	if ($result->num_rows > 0){
		$rank = 1;
    while($row = $result->fetch_assoc()) {
	   
       echo "<tr>";
	   echo "<td>".$rank. "</td>";
	   echo "<td>".$row['Name']. "</td>";
	   echo "<td>".$row['Total_Sales']. "</td>";
	   echo "</tr>";
	   $rank = $rank + 1;
    }
} else {
    echo "0 results";
}
$conn->close();
}
?>
</table>

</body>
</html>