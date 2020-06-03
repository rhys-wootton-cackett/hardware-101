<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Cabin|Roboto|Roboto+Condensed" rel="stylesheet">

    <!-- FontAwesome script -->
    <script src="https://kit.fontawesome.com/21562e03bc.js" crossorigin="anonymous"></script>

    <!-- holder.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.6/holder.min.js" crossorigin="anonymous"></script>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/site.webmanifest">
    <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#eeeeee">

    <!-- Head -->
    <title>Hardware 101</title>
</head>

<body>
    <?php
    require_once 'php/connectdb.php';
    session_start();

    // If a user isn't logged in, simply redirect them to the home page
    if (!isset($_SESSION['username']) && empty($_SESSION['username'])) {
        header("Location: index.php");
    }

    //Get a user's login history
    function getLoginHistoryForUser($db)
    {
        $query = "SELECT * FROM LoginHistory WHERE Username = '" . $_SESSION['username'] . "'";
        $results = mysqli_query($db, $query);
        while ($row = mysqli_fetch_assoc($results)) {
            echo '<li class="list-group-item d-flex justify-content-between lh-condensed">';
            echo '<div>';
            echo '<small class="font-weight-bold">' . $row['LoginDate'] . '</small><br>';
            echo '<small class="text-muted">IP Address: ' . $row['IPAddress'] . '</small>';
            echo '</div>';
            echo '</li>';
        }
    }
    ?>

    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
            <div class="container d-flex justify-content-between">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-home fa-fw"></i>Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="hardware_explained.php"><i class="fas fa-question fa-fw"></i>What is hardware?</a></li>
                        <li class="nav-item"><a class="nav-link" href="hardware_table.php"><i class="fas fa-table fa-fw"></i>Hardware table</a></li>
                        <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                        ?>
                            <li class="nav-item"><a class="nav-link" href="user_hardware.php"><i class="fas fa-desktop fa-fw"></i>&nbsp;<?php echo $_SESSION["username"] ?>'s hardware</a></li>
                            <li class="nav-item active"><a class="nav-link" href="#"><i class="fas fa-cog fa-fw"></i>Settings</a></li>
                        <?php } ?>
                    </ul>
                </div>
                <ul class="nav navbar-nav ml-auto">
                    <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                    ?>
                        <li id="logOutLink" class="nav-item"><a class="nav-link" href="#"><i class="fas fa-sign-out-alt fa-fw"></i>Log out</a></li>
                    <?php } else { ?>
                        <li id="navItemAccount" class="nav-item"><a class="nav-link" href="#" data-toggle="modal" data-target="#modalSignIn"><i class="fas fa-user fa-fw"></i>Sign in</a></li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Main body -->
    <main role="main" class="flex-shrink-0">
        <div class="container" id="tableHardwareDiv">
            <div class="py-5 text-center">
                <h1>Settings</h1>
            </div>
            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">Login history</h4>
                    <ul id="loginHistoryListGroup" class="list-group mb-3">
                        <?php getLoginHistoryForUser($db) ?>
                    </ul>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Account Settings</h4>
                    <form method="post" action="" id="formEmailChange" class="needs-validation" novalidate="">
                        <div class="mb-3">
                            <label>Change your email, but don't change it to your spam one <i class="far fa-angry"></i></label>
                            <div class="input-group">
                                <input type="email" class="form-control" id="changeEmail" placeholder="New email" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-info" type="submit">Change email</button>
                                </div>
                                <div class="invalid-feedback" style="width: 100%;">
                                    A valid email is required.
                                </div>
                            </div>
                        </div>
                    </form>

                    <form id="formPasswordChange" class="needs-validation" novalidate="">
                        <div class="mb-3">
                            <label>Change your current password to something a lot more secure.</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">Current password</span></div>
                                <input type="password" class="form-control" id="changePasswordCurrent" required>
                                <div class="invalid-feedback" style="width: 100%;">
                                    Well you need to tell us your current password!
                                </div>
                            </div>
                            <br>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">New password</span></div>
                                <input type="password" class="form-control" id="changePasswordNew" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,100}$" required>
                                <div class="invalid-feedback" style="width: 100%;">
                                    You need a new password if you want to change it! Remeber it needs these requirements:
                                    <ul>
                                        <li>8 characters long</li>
                                        <li>1 uppercase character</li>
                                        <li>1 number</li>
                                        <li>Your soul... just kidding!</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-info float-right" type="submit">Change password</button>
                    </form>

                    <br><br>
                    <hr>

                    <div>
                        <h6>Clear your login history</h6>
                        <p>If you want to hide from yourself how many times you have logged into this amazing site, just click the button below and it will all dissapear!</p>
                        <button id="clearLoginHistorybtn" class="btn btn-warning" type="button">Clear login history</button>
                    </div>

                    <hr>

                    <div>
                        <h6>Delete your account</h6>
                        <p>If you for some crazy reason want to delete your account, then you can go ahead and do so. We will not be able to recover your details after this process, so think really hard before going ahead with this...</p>
                        <button id="deleteAccountbtn" class="btn btn-danger" type="button">Delete my account... forever</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 fixed-bottom">
        <div class="container" id="footerContainer">
            <div class="row">
                <div class="col">
                    <p class="text-muted"><small><a href="https://getbootstrap.com/" target="_blank">Bootstrap</a> FTW!</small></p>
                </div>
                <div class="col">
                    <p class="text-muted text-center"><small>&copy; 2020</small></p>
                </div>
                <div class="col">
                    <p class="text-muted text-right"><small>Created by RSW</small></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!-- reCAPTCHA v2 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="js/script.js"></script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</body>

</html>