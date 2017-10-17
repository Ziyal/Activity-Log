<?php
// define variables and set to empty values
$activity = $notes = $date = "";
$activityErr = $notesErr = $dateErr = "";
$isValid = true;

// check form inputs for validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["activity"])) {
    $isValid = false;
    $activityErr = "Activity is required";
  } else {
    $activity = test_input($_POST["activity"]);
  }

  if (empty($_POST["notes"])) {
      $isValid = false;
    $notesErr = "Notes is required";
  } else {
    $notes = test_input($_POST["notes"]);
  }

  // if all inputs are valid, enter info into database
  if ($isValid) {
    // connect to MySQL
    $link = mysqli_connect("localhost", "root", "", "activity_log");
    
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    
    // Escape user inputs for security
    $activity = mysqli_real_escape_string($link, $_REQUEST['activity']);
    $notes = mysqli_real_escape_string($link, $_REQUEST['notes']);
    $date = mysqli_real_escape_string($link, $_REQUEST['date']);
    
    // query to enter data
    $sql = "INSERT INTO entries (activity, notes, date) VALUES ('$activity', '$notes', '$date')";
    if(mysqli_query($link, $sql)){
        header("location:home.php");
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    
    // close connection
    mysqli_close($link);
  }

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Activity Log</title>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>

    <body>
        
        <h1>Activity Log</h1>
        <div class="container">
            <div class="activities-container">
                <div class="activities-table">
                    <?php
                        
                        $link = mysqli_connect("localhost", "root", "", "activity_log");
                        
                        if($link === false){
                            die("ERROR: Could not connect. " . mysqli_connect_error());
                        }
                        
                        // retrieve entries from database and put them into a table
                        $sql = "SELECT * FROM entries ORDER BY date ";
                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo "<table>";
                                    echo "<tr>";
                                        echo "<th>Activity</th>";
                                        echo "<th>Notes</th>";
                                        echo "<th>Date</th>";
                                    echo "</tr>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['activity'] . "</td>";
                                        echo "<td>" . $row['notes'] . "</td>";
                                        echo "<td>" . $row['date'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                                // Free result set
                                mysqli_free_result($result);
                            } else{
                                echo "No records matching your query were found.";
                            }
                        } else{
                            echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                        }
                        
                        // Close connection
                        mysqli_close($link);
                    ?>
                </div>

                <div class="activities-form">
                    <h2>Add an Activity!</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                        <span class="error"><?php echo $activityErr;?></span>
                        <input type="text" name="activity" placeholder="Activity" value="<?php echo $activity;?>"><br>
                        <span class="error"><?php echo $notesErr;?></span>
                        <input type="text" name="notes" placeholder="Notes" value="<?php echo $notes;?>"><br>
                        <span class="error"><?php echo $dateErr;?></span>
                        <input type="date" name="date"><br>
                        <input type="submit" value="Add Activity">
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>