<!DOCTYPE html>
<html>
    <head>
    <title>Activity Log</title>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">-->
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>

    <body>
        
        <div class="container">
            <h1>Activity Log</h1>
            <div class="activities-container">
                <div class="activities-table">
                    <?php
                        /* Attempt MySQL server connection. Assuming you are running MySQL
                        server with default setting (user 'root' with no password) */
                        $link = mysqli_connect("localhost", "root", "", "activity_log");
                        
                        // Check connection
                        if($link === false){
                            die("ERROR: Could not connect. " . mysqli_connect_error());
                        }
                        
                        // Attempt select query execution
                        $sql = "SELECT * FROM entries";
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
                    <form action="insert.php" method="post">
                        <span>Activity: </span><input type="text" name="activity"><br>
                        <span>Notes: </span><input type="text" name="notes"><br>
                        <span>Date: </span><input type="date" name="date"><br>
                        <input type="submit" value="Add Activity">
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>