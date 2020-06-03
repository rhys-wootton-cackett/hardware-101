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
    session_start();
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
                        <li class="nav-item active"><a class="nav-link" href="#"><i class="fas fa-table fa-fw"></i>Hardware table</a></li>
                        <?php if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
                        ?>
                            <li class="nav-item"><a class="nav-link" href="user_hardware.php"><i class="fas fa-desktop fa-fw"></i>&nbsp;<?php echo $_SESSION["username"] ?>'s hardware</a></li>
                            <li class="nav-item"><a class="nav-link" href="settings.php"><i class="fas fa-cog fa-fw"></i>Settings</a></li>
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
                <h1>Hardware Table</h1>
                <p class="lead">Everyone who has told us what hardware they have will be shown here. You can search for specific things, and clicking on a row will give you a
                    detailed breakdown of their operating system, CPU and GPUs.</p>
            </div>
            <div id="searchTable">
                <div class="input-group">
                    <div class="input-group-prepend d-none d-md-block">
                        <span class="input-group-text" id="inputGroup-sizing-default">Search for anything in the table, we won't judge</span>
                    </div>
                    <input type="text" class="form-control" id="hardwareSearchTable">
                </div>
            </div>
            <br>
            <div id="makeHardwareTableScrollable">
                <table class="table table-hover" id="tableHardwareDatabase">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Operating System</th>
                            <th scope="col">CPU</th>
                            <th scope="col">GPU</th>
                            <th scope="col">RAM</th>
                            <th scope="col">Drives</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Modal explaining a user's hardware -->
    <div class="modal fade" id="modalShowUserHardwareExplained" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center">User's Hardware Explained</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <br>
                        <div class="card-columns" id="hardwareCardsExplained">
                            <div class="card bg-light" id="hardwareCardExplainOperatingSystem">
                                <img class="card-img-top" src="" alt="Image of an operating system">
                                <div class="card-img-overlay">
                                    <p><span><a href="" target="_blank">Source</a></span></p>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"></h5>
                                    <p class="card-text"></p>
                                </div>
                            </div>
                            <div class="card bg-light" id="hardwareCardExplainCPU">
                                <img class="card-img-top" src="img/noimage.png" alt="Image of a CPU" id="hardwareCardExplainCPUImage">
                                <div class="card-body">
                                    <h5 class="card-title">Title</h5>
                                    <p class="card-text" id="hardwareCardExplainCPUParagraph">Paragraph</p>
                                    <div class="table-responsive">
                                        <table class="table table-sm" id="hardwareCardExplainCPUTable">
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    Information taken from <a href="http://en.wikichip.org" target="_blank">WikiChip</a>
                                </div>
                            </div>
                            <div class="card bg-light" id="hardwareCardExplainGPU1">
                                <img class="card-img-top" src="img/noimage.png" alt="Image of a GPU" id="">
                                <div class="card-body">
                                    <h5 class="card-title">Title</h5>
                                    <p class="card-text">Paragraph</p>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer text-muted">
                                    Information taken from <a href="http://www.techpowerup.com/gpu-specs" target="_blank">TechPowerUp</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for logging in and signing up -->
    <div class="modal fade" id="modalSignIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="container">
                    <form method="post" action="" class="needs-validation" id="form-signin" novalidate>
                        <input type="hidden" name="form" value="loginAccount" />
                        <h3 class="text-center">Sign in</h3>
                        <div class="input-group">
                            <input type="text" id="inputUsernameSignIn" class="form-control" placeholder="Username" required>
                            <div class="invalid-feedback">
                                Well you must have a username.
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="password" id="inputPasswordSignIn" class="form-control" placeholder="Password" required="">
                            <div class="invalid-feedback">
                                Do you not remember your password?
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                        <button class="btn btn-lg btn-secondary btn-block" data-toggle="modal" data-dismiss="modal" data-target="#modalCreateAccount">Wait, you don't have an account? Lets fix that!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCreateAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="container">
                    <form action="" class="needs-validation" id="form-createAccount" novalidate>
                        <input type="hidden" name="form" value="createAccount" />
                        <h3 class="text-center">Create an account</h3>
                        <div class="input-group">
                            <input type="text" name="firstname" id="inputFirstName" class="form-control" placeholder="First names" required>
                            <div class="invalid-feedback">
                                You must have at least one first name. Give it to us!
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" name="surname" id="inputSurname" class="form-control" placeholder="Surname" required>
                            <div class="invalid-feedback">
                                Cmon, don't forget your surname either.
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required>
                            <div class="invalid-feedback">
                                Last time I checked, that email isn't real.
                            </div>
                        </div>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                            </div>
                            <input type="text" name="username" id="inputUsername" class="form-control" placeholder="Username" maxLength="30" required>
                            <div class="invalid-feedback" id="usernameFeedback">
                                We need a username!
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" pattern="^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,100}$" required>
                            <div class="invalid-feedback">
                                Please enter a password with the minimum requirements:
                                <ul>
                                    <li>8 characters long</li>
                                    <li>1 uppercase character</li>
                                    <li>1 number</li>
                                    <li>Your soul... just kidding!</li>
                                </ul>
                            </div>
                        </div>
                        <div class="input-group justify-content-center">
                            <div class="g-recaptcha" data-sitekey="6LcmJOMUAAAAADW2YsatL5Y4m89rPTJV2RnIY_7m"></div>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Create account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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