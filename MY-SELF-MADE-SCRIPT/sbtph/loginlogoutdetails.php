<?php

require('database.php');

$extension = $_GET['extension'];
$name = $_GET['username'];

$sql = "SELECT * FROM  logs WHERE extension='$extension'  ORDER BY timestamp DESC";
$result = $conn->query($sql);


?>

<?php include ('header.php');?>

    <div class="nav-scroller bg-blue shadow-sm">
      <nav class="nav nav-underline">
       
        <a class="nav-link " href="active.php">ACTIVE</a>
        <a class="nav-link" href="inactive.php">INACTIVE</a>
        <a class="nav-link" href="call-summary.php">CALL-SUMMARY</a>
       
      </nav>
    </div>

    <main role="main" class="container">
          <div>
              <h2 class="text-center font-weight-bold text-primary"><?php echo $name . "<span class='text-danger'> LOGIN/LOGOUT STATISTICS</span>"?></h2>
              <table class="table">
                <thead class="thead-dark">
                   <tr>
                      <th scope="col">#</th>
                      <th scope="col">LOG</th>
                      <th scope="col">DATE</th>
                      <th scope="col">TIME</th>
                      <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                       $test=1;
                        if($result->num_rows > 0 ) {
                          $id=1;
                           while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                    echo "<th scope='row'>". $id. "</th>";
                                    echo "<td>" . $row['log'] . "</td>";
                                    echo "<td>" . $row['logdate'] . "</td>";
                                    echo "<td>" . $row['logtime'] . "</td>";
                                    
                                echo "</tr>";
                                $id = $id+1;
                          }
                        }else{
                            echo "<tr>";
                            echo "<th scope='row'></th>";
                            echo "<td>NO lOG DETAILS</td>";
                            echo "<tr>";
                      } 
                  $conn->close();   
                  ?>
                </tbody>
            </table>
          </div>
       
    </main>

<?php include ('footer.php');?>
