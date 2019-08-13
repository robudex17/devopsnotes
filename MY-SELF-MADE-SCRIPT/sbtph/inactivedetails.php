<?php
$servername = "localhost";
$username = "python";
$password = "sbtph@2018";
$dbname = "sbtphcsd";

$extension = $_GET['extension'];
$name = $_GET['username'];

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM  logs WHERE extension='$extension'  ORDER BY timestamp DESC";
$result = $conn->query($sql);


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>CSD PHILIPPINES INBOUND MONITORING</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/offcanvas.css" rel="stylesheet">
  </head>

  <body class="bg-light">

    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
      <a class="navbar-brand mr-auto mr-lg-0 " href="#">CSD PHILIPPINES INBOUND MONITORING</a>
      <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
        <span class="navbar-toggler-icon"></span>
      </button>
    </nav>

    <div class="nav-scroller bg-blue shadow-sm">
      <nav class="nav nav-underline">
       
        <a class="nav-link " href="active.php">ACTIVE</a>
        <a class="nav-link btn btn-primary btn-lg active" href="inactive.php">INACTIVE</a>
       
      </nav>
    </div>

    <main role="main" class="container">
          <div>
              <h2 class="text-center font-weight-bold text-primary"><?php echo $name . "<span class='text-danger'> STATISTICS</span>"?></h2>
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
                            echo "<td>NO LOG DETAILS</td>";
                            echo "<tr>";
                      } 
                  $conn->close();   
                  ?>
                </tbody>
            </table>
          </div>
       
    </main>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <script src="holder.min.js"></script>
    <script src="offcanvas.js"></script>
  </body>
</html>
