<?php
require_once 'connectdb.php';

//Store session details for users
session_start();

//Check that the form is not empty
if (empty($_POST)) {
    return;
}

//If the page loaded is the hardware table page, simply return all the data in a JSON format
if ($_POST['window'] == 'hardwaretable') {
    //Select all rows from the table
    $query = "SELECT * FROM Hardware";
    $rows = array();
    $result = $db->query($query);
    while($r = mysqli_fetch_assoc($result)) {
        $rows[] = $r;
    }

    //Form the response into a JSON structure and send back to AJAX
    $jsonResponse = htmlspecialchars_decode(json_encode($rows));

    //I have the fix the JSON as it adds an existing JSON structure
    $jsonResponse = str_replace('"[', '[', $jsonResponse);
    $jsonResponse = str_replace(']"', ']', $jsonResponse);
    echo $jsonResponse;
    return;
}

//If a record already exists and the page is freshly loaded, load it into the form 
$query = "SELECT COUNT(*) AS count FROM Hardware WHERE Username = '" . $_SESSION['username'] . "'";
$result = $db->query($query);
$data = $result->fetch_assoc();

if ($data['count'] > 0 && $_POST['window'] == 'loaded') {
    //Get the record
    $query = "SELECT * FROM Hardware WHERE Username = '" . $_SESSION['username'] . "'";
    $result = $db->query($query);
    $data = $result->fetch_assoc();

    //Form the response into a JSON structure and send back to AJAX
    $jsonResponse = htmlspecialchars_decode(json_encode($data));

    //I have the fix the JSON as it adds an existing JSON structure
    $jsonResponse = str_replace('"[', '[', $jsonResponse);
    $jsonResponse = str_replace(']"', ']', $jsonResponse);
    echo $jsonResponse;
    return;
}

//Ensure data and remove any sql and javascript injections
$hardwareName = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['hardwareName'])));
$os = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['os'])));
$architecture = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['architecture'])));
$cpu = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['cpu'])));
$ram = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['ram'])));
$gpus = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['gpus'])));
$drives = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['drives'])));


//If the username exists then update the current record, otherwise create a new one.
if ($data['count'] > 0) {
    //Prepare the query, set its parameters and run it
    if ($query = $db->prepare("UPDATE Hardware SET HardwareName = ?, OS = ?, OSArchitecture = ?, CPU = ?, GPU = ?, RAM = ?, Drive = ? WHERE Username = ?")) {
        $query->bind_param('sssssiss', $hardwareName, $os, $architecture, $cpu, $gpus, $ram, $drives, $_SESSION['username']);
        $query->execute();

        //See if the query was successful
        if ($query->affected_rows > 0) {
            echo "updated-Y";
        }
    } else {
        //A database error has occured
        echo "updated-N";;
    }
} else {
    //Prepare the query, set its parameters and run it
    if ($query = $db->prepare("INSERT INTO Hardware (Username, HardwareName, OS, OSArchitecture, CPU, GPU, RAM, Drive) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
        $query->bind_param('ssssssis', $_SESSION['username'], $hardwareName, $os, $architecture, $cpu, $gpus, $ram, $drives);
        $query->execute();

        //See if the query was successful
        if ($query->affected_rows > 0) {
            echo "added-Y";
        }
    } else {
        //A database error has occured
        echo "added-N";
    }
}
