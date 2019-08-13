<?php
require('database.php');


$sql = "SELECT * FROM  csdinbound WHERE receive_calls=1";
$result = $conn->query($sql);

function secToHR($seconds) {
  $hours = floor($seconds / 3600);
  $minutes = floor(($seconds / 60) % 60);
  $seconds = $seconds % 60;
  return "$hours:$minutes:$seconds";
}

?>

<?php include ('header.php');?>

<div class="nav-scroller bg-blue shadow-sm">
      <nav class="nav nav-underline">
       
        <a class="nav-link btn btn-primary btn-lg active " href="active.php">ACTIVE</a>
        <a class="nav-link " href="inactive.php">INACTIVE</a>
        <a class="nav-link" href="call-summary.php">CALL-SUMMARY</a>

       
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
                      <th scope="col">LOGIN/LOGOUT</th>
                      <th scope="col">LOGIN DURATION</th>
                  </tr>
                </thead>
                <tbody id="tbody">
                  <?php 
                       
                        if($result->num_rows > 0 ) {
                          $id=1;
                           while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                    echo "<th scope='row'>". $id. "</th>";
                                    echo "<td>" . $row['extension'] . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td>";?>
                                       <a  href="loginlogoutdetails.php?extension=<?php echo $row['extension']?>&username=<?php echo $row['username']?>">Click Details</a>
                                    <?php
                                    echo "</td>";
                                    $sqlloginduration = "SELECT * FROM logs WHERE log='IN' AND extension='".$row['extension']."' ORDER by timestamp DESC LIMIT 1;";
                                    $resultloginduration  = $conn->query($sqlloginduration);
                                    $duration = 0; 
                                    while ($row_duration =$resultloginduration->fetch_assoc()) {
                                      $currenttimestamp = time();
                                      
                                      $duration =  ($currenttimestamp - strtotime($row_duration['timestamp']));

                                    }
                                    $duration = secToHR($duration);
                                    echo "<td>" .$duration. "</td>";

                                $id = $id+1;
                          }
                        }else{
                            echo "<tr>";
                            echo "<th scope='row'></th>";
                            echo "<td>NO ACTIVE AGENTS</td>";
                            echo "<tr>";
                      } 
                  $conn->close();   
                  ?>
                </tbody>
            </table>
          </div>
       
    </main>



 <?php include ('footer.php');?>