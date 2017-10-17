<?php
    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    $link = mysqli_connect("localhost", "root", "", "activity_log");
    
    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    
    // Escape user inputs for security
    $activity = mysqli_real_escape_string($link, $_REQUEST['activity']);
    $notes = mysqli_real_escape_string($link, $_REQUEST['notes']);
    $date = mysqli_real_escape_string($link, $_REQUEST['date']);
    
    // attempt insert query execution
    $sql = "INSERT INTO entries (activity, notes, date) VALUES ('$activity', '$notes', '$date')";
    if(mysqli_query($link, $sql)){
        echo "Records added successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }
    
    // close connection
    mysqli_close($link);
?>