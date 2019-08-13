<?php
	require('database.php');

	$sql = "SELECT * FROM  csdinbound";
	$result = $conn->query($sql);

	 if (isset($_GET['getdate'])){
	   $getdate = $_GET['getdate'];
	 }else {
	 	$getdate = date('Y-m-d');
	}
?>

<?php include ('header.php');?>


<div class="nav-scroller bg-blue shadow-sm">
      <nav class="nav nav-underline">       
        <a class="nav-link" href="active.php">ACTIVE</a>
        <a class="nav-link" href="inactive.php">INACTIVE</a>
        <a class="nav-link btn btn-primary btn-lg active" href="call-summary.php">CALL-SUMMARY</a>       
      </nav>
</div>

    <main role="main" class="container">
          <div>
              <table class="table">
                <thead class="thead-dark">
                   <tr>
                      <th scope="col">#</th>
                      <th scope="col">EXTENSION</th>
                      <th scope="col">NAME</th>
                      <th scope="col" class="text-center">Total Calls Answered</th>
                      <th scope="col">Total Calls Duration</th>
                      <th scope="col">
                      	<form action="call-summary.php">
                      		  <input type="date" name="getdate" id="datePicker"> 	
                              <input class="btn" type="submit"  id=clickdate" value="Select_Date">
                          </form>
                      </th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    function secToHR($seconds) {
                       $hours = floor($seconds / 3600);
                        $minutes = floor(($seconds / 60) % 60);
                        $seconds = $seconds % 60;
                        return "$hours:$minutes:$seconds";
                    }
                       
                        if($result->num_rows > 0 ) {
                          $id=1;
                           while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                    echo "<th scope='row'>". $id. "</th>";
                                    echo "<td>" . $row['extension'] . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";

                                    //This Section Get the Total Answered Called of each agents...
                                     $querycalls = "SELECT StartTimeStamp,EndTimeStamp FROM inbound_callstatus WHERE getDate='".$getdate."' AND CallStatus='ANSWER'  AND WhoAnsweredCall='".$row['extension']."'";
                                    $resultquerycalls = $conn->query($querycalls);
                                    $row_cnt = $resultquerycalls->num_rows;       
                                    echo "<td class='text-center'>" .$row_cnt. "</td>";
                                    // End of Section 

                                    
                                    //This section calculate the total call duration of each agents..
                                    $total=0;
                                    while($row_calls = $resultquerycalls->fetch_assoc()) {

                                        $endtime = explode("-", $row_calls['EndTimeStamp']);
                                        $startime = explode("-", $row_calls['StartTimeStamp']);

                                        $total = $total + ( (strtotime($endtime[0]) + strtotime($endtime[1])) - (strtotime($startime[0]) +strtotime($startime[1])) );                                   
                                    } 
                                    $total_duration = secToHR($total);
                                    echo "<td class='text-justify'>" .$total_duration . "</td>";
                                    //End of Section..

                                    echo "<td>" ;?>
                                    	 <a  href="agent-call-details.php?extension=<?php echo $row['extension']?>&username=<?php echo $row['username']?>	&getdate=<?php echo $getdate?>"><?php echo $getdate; ?>
                                    	 </a>
                                    <?php
                                     echo "</td>";
                                    
                                 echo "</tr>";

                                $id = $id+1;
                          }
                        }else{
                            echo "<tr>";
                            echo "<th scope='row'></th>";
                            echo "<td>NO CALL SUMMARY AVAILABLE</td>";
                            echo "<tr>";
                      } 
                  $conn->close();   
                  ?>
                </tbody>
            </table>
          </div>
       
    </main>
 <?php include ('footer.php');?>