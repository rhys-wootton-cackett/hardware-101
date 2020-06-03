<?php
require_once 'connectdb.php';

//Store session details for users
session_start();

//Check what form is being submitted
if (!empty($_POST) && $_POST['form'] == 'createAccount') {
    //Ensure data and remove any sql and javascript injections
    $firstname = htmlspecialchars($_POST['firstname']);
    $firstname = strip_tags($firstname);
    $firstname = mysqli_real_escape_string($db, $firstname);

    $surname = htmlspecialchars($_POST['surname']);
    $surname = strip_tags($surname);
    $surname = mysqli_real_escape_string($db, $surname);

    $email = htmlspecialchars($_POST['email']);
    $email = strip_tags($email);
    $email = mysqli_real_escape_string($db, $email);

    $username = htmlspecialchars($_POST['username']);
    $username = strip_tags($username);
    $username = mysqli_real_escape_string($db, $username);

    $password = htmlspecialchars($_POST['password']);
    $password = strip_tags($password);
    $password = mysqli_real_escape_string($db, $password);

    /*
    Title: Setting Up reCAPTCHA 2.0 with PHP Demo/Tutorial
    Author: Kaplan Komputing
    Date: 2020
    Availability: https://www.kaplankomputing.com/blog/tutorials/recaptcha-php-demo-tutorial/
    */
    //Create the POST query to see if the reCAPTCHA is valid or not
    $response = $_POST['recaptcha'];
    $post = http_build_query(
        array(
            'response' => $response,
            'secret' => 'GET_A_KEY',
            'remoteip' => $_SERVER['REMOTE_ADDR']
        )
    );
    $opts = array(
        'http' =>
        array(
            'method' => 'POST',
            'header' => 'application/x-www-form-urlencoded',
            'content' => $post
        )
    );

    $context = stream_context_create($opts);
    $serverResponse = @file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);

    //Check the server response
    if (!$serverResponse) {
        $errorMessage = 'Failed to validate ReCAPTCHA. Please try again!';
        echo "<script type='text/javascript'>alert('$errorMessage');</script>";
        exit();
    }

    //If the response is invalid, exit.
    $result = json_decode($serverResponse);
    if (!$result->success) {
        $errorMessage = 'You failed the reCAPTCHA test, so you must be a robot. If not, retry!';
        echo "<script type='text/javascript'>alert('$errorMessage');</script>";
        exit();
    }

    //Check to see if the username already exists in the database
    $query = "SELECT COUNT(*) AS count FROM UserAccount WHERE Username = '" . $username . "'";
    $result = $db->query($query);
    $data = $result->fetch_assoc();

    //If the username exists, then tell the user they need a different one and do not submit the form.
    if ($data['count'] > 0) {
        echo "username";
    } else {
        //Hash the password to be stored in the database
        $passwordHash = md5($password);

        //Prepare the query, set its parameters and run it
        if ($query = $db->prepare("INSERT INTO UserAccount (Username, Email, Password, FirstNames, Surname) VALUES (?, ?, ?, ?, ?)")) {
            $query->bind_param('sssss', $username, $email, $passwordHash, $firstname, $surname);
            $query->execute();

            //See if the query was successful
            if ($query->affected_rows > 0) {
                echo "Yes";
            }
        } else {
            //A database error has occured
            echo "No";
        }
    }
}

if (!empty($_POST) && $_POST['form'] == 'loginAccount') {
    //Ensure data and remove any sql injections
    $username = htmlspecialchars($_POST['username']);
    $username = strip_tags($username);
    $username = mysqli_real_escape_string($db, $username);

    $password = htmlspecialchars($_POST['password']);
    $password = strip_tags($password);
    $password = mysqli_real_escape_string($db, $password);

    //Hash the password to check the one in the databas
    $passwordHash = md5($password);

    //Prepare the query, set its parameters and run it
    $query = "SELECT * FROM UserAccount WHERE Username = '$username' AND Password = '$passwordHash'";
    $results = mysqli_query($db, $query);

    if (mysqli_num_rows($results) == 0) {
        echo "No accounts";
    } else if (mysqli_num_rows($results) == 1) {
        while ($row = $results->fetch_assoc()) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            echo 'Yes';
        }

        //Add a record to the LoginHistory table to store that they have logged in
        if ($query = $db->prepare("INSERT INTO LoginHistory (Username, IPAddress, LoginDate) VALUES (?, ?, ?)")) {
            /*
            Title: Get the client IP address
            Author: www.w3resource.com
            Date: 2020
            Available: https://www.w3resource.com/php-exercises/php-basic-exercise-5.php
            */
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip_address = $_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else {
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }

            $query->bind_param('sss', $_SESSION['username'], $ip_address, $date = date('jS F Y H:i:s', time()));
            $query->execute();
        }
    }
}

if (!empty($_POST) && $_POST['form'] == 'logout') {
    logOutOfAccount();
}

if (!empty($_POST) && $_POST['form'] == 'changeEmail') {
    //Strip email of all tags and sql injections
    $email = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['email'])));

    //Change the email
    if ($query = $db->prepare("UPDATE UserAccount SET Email = ? WHERE Username = ?")) {
        $query->bind_param('ss', $email, $_SESSION['username']);
        $query->execute();

        //See if the query was successful
        if ($query->affected_rows > 0) {
            echo "Yes";
        }
    } else {
        //A database error has occured
        echo "No";
    }
}

if (!empty($_POST) && $_POST['form'] == 'changePassword') {
    //Strip passwords of all tags and sql injections
    $passOld = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['passOld'])));
    $passNew = mysqli_real_escape_string($db, strip_tags(htmlspecialchars($_POST['passNew'])));

    //Check the old password matches, and if not, then reject
    $query = "SELECT COUNT(*) AS count FROM UserAccount WHERE Username = '" . $_SESSION['username'] . "' AND Password = '" . md5($passOld) . "'";
    $result = $db->query($query);
    $data = $result->fetch_assoc();

    if ($data['count'] == 0) {
        echo "Your old password did not match with the one we have.";
        return;
    }

    //Change the password
    if ($query = $db->prepare("UPDATE UserAccount SET Password = ? WHERE Username = ?")) {
        $query->bind_param('ss', md5($passNew), $_SESSION['username']);
        $query->execute();

        //See if the query was successful
        if ($query->affected_rows > 0) {
            echo "Yes";
        }
    } else {
        //A database error has occured
        echo "Couldn't set new password. Your old one was kept.";
    }
}

if (!empty($_POST) && $_POST['form'] == 'clearLoginHistory') {
    if ($query = $db->prepare("DELETE FROM LoginHistory WHERE Username = ?")) {
        $query->bind_param('s', $_SESSION['username']);
        $query->execute();

        //See if the query was successful
        if ($query->affected_rows > 0) {
            echo "Your login history was cleared!";
        } else {
            echo "Couldn't clear your login history.";
        }
    } else {
        //A database error has occured
        echo "An error happened somewhere along the way...";
    }
}

if (!empty($_POST) && $_POST['form'] == 'deleteAccount') {
    //Since foreign keys can pose an issue, just disable them for now
    //$db->query("SET foreign_key_checks = 0");

    if ($query = $db->prepare("DELETE FROM UserAccount WHERE Username = ?")) {
        $query->bind_param('s', $_SESSION['username']);
        $query->execute();

        //See if the query was successful
        if ($query->affected_rows > 0) {
            echo "Your account was deleted. It was nice knowing you!";
            logOutOfAccount();
        } else {
            echo "Your account couldn't be deleted for some reason, try again.";
        }
    } else {
        //A database error has occured
        echo "An error happened somewhere along the way...";
    }

    //Enable the foreign key checks
    //$db->query("SET foreign_key_checks = 1");
}

function logOutOfAccount() {
    session_start();

    // Unset all of the session variables.
    $_SESSION = array();

    //Delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
}
