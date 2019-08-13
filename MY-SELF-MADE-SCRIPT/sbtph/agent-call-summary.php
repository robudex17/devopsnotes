<?php

require('database.php');

if (isset($_GET['extension'])){
   $extension = $_GET['extension'];
 }
 if (isset($_GET['username'])){
   $username = $_GET['username'];
 }
 if (isset($_GET['getdate'])){
   $getdate = $_GET['getdate'];
 }
 

$sql = "SELECT * FROM  logs WHERE extension='$extension'  ORDER BY timestamp DESC";
$result = $conn->query($sql);


?>

<?php include ('header.php');?>

    <div class="nav-scroller fixed-top bg-blue shadow-sm">
      <nav class="nav nav-underline navbar-expand-lg  fixed-top">
       
        <a class="nav-link " href="active.php">ACTIVE</a>
        <a class="nav-link" href="inactive.php">INACTIVE</a>
        <a class="nav-link" href="call-summary.php">CALL-SUMMARY</a>
       
      </nav>
    </div>

    <main role="main" class="container">
          <div>
              <h2 class="text-center font-weight-bold text-primary"><?php echo $username . "<span class='text-danger'> CALLS STATISTICS</span>"?></h2>
              <table class="table">
                <thead class="thead-dark">
                   <tr>
                      <th scope="col">#</th>
                      <th scope="col">Total Calls Answered</th>
                      <th scope="col">Total Calls Duration</th>
                      <th scope="col">Current Date</th>
                      <th scope="col">Details</th>
                      <th scope="col"></th>
                      <th scope="col"><input type="date" name=""><input type="submit" name="" value="SEARCHD DATE"></th>
                  </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
          </div>
       
    </main>

<?php include ('footer.php');?>
