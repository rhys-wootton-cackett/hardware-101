<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Cache-control" content="no-cache">

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Cabin|Roboto|Roboto+Condensed" rel="stylesheet">

    <!-- FontAwesome script -->
    <script src="https://kit.fontawesome.com/21562e03bc.js" crossorigin="anonymous"></script>

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

    // If a user isn't logged in, simply redirect them to the home page
    if (!isset($_SESSION['username']) && empty($_SESSION['username'])) {
        header("Location: index.php");
    }

    // Reads a file from the server and echos it's results to a dropdown menu.
    function readTextFileAndPopulateDropdown($filename)
    {
        $file = fopen($filename, "r");
        echo "<script>console.log('$filename');</script>";

        while (!feof($file)) {
            echo '<option>' . fgets($file) . "</option>";
        }

        fclose($file);
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
                            <li class="nav-item active"><a class="nav-link" href="#"><i class="fas fa-desktop fa-fw"></i>&nbsp;<?php echo $_SESSION["username"] ?>'s hardware</a></li>
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
        <div class="container" id="userHardwareDiv">
            <div class="py-5 text-center">
                <h1><?php echo $_SESSION["username"] ?>'s hardware</h1>
                <p class="lead">Here you can create a new hardware configuration for a computer that you currently have, or modify your existing one.</p>
            </div>

            <form action="" class="needs-validation" id="form-UserHardware" autocomplete="off" novalidate>
                <div class="mb-3" id="formName">
                    <label for="hardwareName">Personal Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="hardwareName" id="hardwareName" placeholder="e.g. SEXY PC, Desktop-5FjS942, My girlfriend/boyfriend etc." required>
                        <div class="input-group-append">
                            <span class="input-group-text" id="inputGroupPrepend">
                                <a data-toggle="tooltip" data-placement="right" title="This is a name that you want to give this computer to identify it. Make it special!">
                                    <i class="fas fa-info-circle"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row" id="formOS">
                    <div class="col-md-10 mb-3">
                        <label>Operating System</label>
                        <div>
                            <select class="selectpicker" title="Select 'other' if yours isn't listed" data-live-search="true" id="selectpickerOS" data-width="100%" data-size="6" required>
                                <optgroup label="Microsoft Windows">
                                    <option>Windows 10</option>
                                    <option>Windows 8.1</option>
                                    <option>Windows 8</option>
                                    <option>Windows 7</option>
                                </optgroup>
                                <optgroup label="Linux">
                                    <option>Ubuntu</option>
                                    <option>Linux Mint</option>
                                    <option>openSUSE</option>
                                </optgroup>
                                <optgroup label="Apple macOS">
                                    <option>macOS 10.15 Catalina</option>
                                    <option>macOS 10.14 Mojave</option>
                                    <option>macOS 10.13 High Sierra</option>
                                </optgroup>
                                <option data-divider="true"></option>
                                <option>Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="float-md-right" data-toggle="tooltip" data-placement="right" title="Refers to how many bits your operating system can send to the CPU to be processed per second. This can be found in your system settings.">
                            Architecture <i class="fas fa-info-circle"></i>
                        </label>
                        <br>
                        <div id="groupArchitecture" class="btn-group btn-group-toggle float-md-right" data-toggle="buttons" required>
                            <label class="btn btn-light">
                                <input type="radio" name="architectureOptions" value="x86" required> x86
                            </label>
                            <label class="btn btn-light">
                                <input type="radio" name="architectureOptions" value="x64" required> x64
                            </label>
                        </div>

                    </div>
                </div>

                <hr>

                <div class="mb-3" id="formCPU">
                    <label>Central Processing Unit</label>
                    <div>
                        <select class="selectpicker" title="You must have one of these. If not we'll be shocked." data-live-search="true" id="selectpickerCPU" data-width="100%" data-size="6" required>
                            <!-- POPULATE WITH INTEL CPUs -->
                            <optgroup label="Intel Processors">
                                <?php readTextFileAndPopulateDropdown("txt/cpulistintel.txt") ?>
                            </optgroup>

                            <!-- POPULATE WITH AMD CPUs -->
                            <optgroup label="AMD Processors">
                                <?php readTextFileAndPopulateDropdown("txt/cpulistamd.txt") ?>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <hr>

                <div class="mb-3" id="formGPU">
                    <label>Graphical Processing Unit</label>
                    <div id="gpuSelector1">
                        <select class="selectpicker gpuSelect" data-dropup-auto="false" data-live-search="true" data-width="100%" data-size="6" required>
                            <!-- POPULATE WITH AMD GPUs -->
                            <optgroup label="AMD FirePro Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/amd-firepro.txt") ?>
                            </optgroup>
                            <optgroup label="AMD Radeon 5xxx Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/amd-radeon-5xxx.txt") ?>
                            </optgroup>
                            <optgroup label="AMD Radeon Pro">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/amd-radeon-pro.txt") ?>
                            </optgroup>
                            <optgroup label="AMD Radeon R5 Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/amd-radeon-r5.txt") ?>
                            </optgroup>
                            <optgroup label="AMD Radeon R7 Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/amd-radeon-r7.txt") ?>
                            </optgroup>
                            <optgroup label="AMD Radeon R9 Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/amd-radeon-r9.txt") ?>
                            </optgroup>
                            <optgroup label="AMD RX Vega/Vega Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/amd-radeon-vega.txt") ?>
                            </optgroup>

                            <!-- POPULATE WITH NVIDEA GPUs -->
                            <optgroup label="NVIDIA GeForce GTX Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/nvidia-geforce-gtx.txt") ?>
                            </optgroup>
                            <optgroup label="NVIDIA GeForce MX Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/nvidia-geforce-mx.txt") ?>
                            </optgroup>
                            <optgroup label="NVIDIA GeForce RTX Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/nvidia-geforce-rtx.txt") ?>
                            </optgroup>
                            <optgroup label="NVIDIA GRID Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/nvidia-grid.txt") ?>
                            </optgroup>
                            <optgroup label="NVIDIA Quadro Series">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/nvidia-quadro.txt") ?>
                            </optgroup>
                            <optgroup label="NVIDIA Tesla Series'">
                                <?php readTextFileAndPopulateDropdown("txt/gpus/nvidia-tesla.txt") ?>
                            </optgroup>
                        </select>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md mb-3">
                            <button type="button" id="btnAddGpu" class="btn btn-info btn-sm"><i class="fas fa-plus-square"></i>&nbsp;You've got another graphics card!?</button>
                        </div>
                        <div class="col-md mb-3">
                            <button type="button" id="btnRemoveGpu" class="btn btn-warning btn-sm float-md-right" disabled><i class="fas fa-trash-alt"></i>&nbsp;Remove the last graphics card</button>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-3" id="formRAM">
                    <label>Random Access Memory</label>
                    <div class="row">
                        <div class="col-md-10 mb-3">
                            <input type="range" class="custom-range" min="0" max="32" id="ramRange">
                        </div>
                        <div class="col-md-2 mb-3">
                            <p id="ramRangeValue">16GB</p>
                        </div>
                    </div>
                </div>

                <hr>

                <div id="formDrives">
                    <label>Hard Disk Drive/Solid State Drive</label>
                    <div class="row" id="driveRow1">
                        <div class="col-md-8 mb-3">
                            <div class="input-group">
                                <input type="number" min="0" max="10000" class="form-control" name="driveSize" id="driveSize" placeholder="Size (e.g. 128)" required>
                                <div class="input-group-append">
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        Gigabytes (GB)
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="btn-group btn-group-toggle float-md-right" data-toggle="buttons" required>
                                <label class="btn btn-light">
                                    <input type="radio" name="driveOptions1" value="Hard Disk Drive" id="driveOptions1" required> Hard Disk Drive
                                </label>
                                <label class="btn btn-light">
                                    <input type="radio" name="driveOptions1" value="Solid State Drive" id="driveOptions1" required> Solid State Drive
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3">
                            <button type="button" id="btnAddDrive" class="btn btn-info btn-sm"><i class="fas fa-plus-square"></i>&nbsp;You've got another drive!?</button>
                        </div>
                        <div class="col-md mb-3">
                            <button type="button" id="btnRemoveDrive" class="btn btn-warning btn-sm float-md-right" disabled><i class="fas fa-trash-alt"></i>&nbsp;Remove the last drive</button>
                        </div>
                    </div>
                </div>

                <hr>
                <button type="submit" id="btnSubmit" class="btn btn-primary btn-block btn-lg"><i class="fas fa-save"></i>&nbsp;Save this configuration!</button>
            </form>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
    <script src="js/script.js"></script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
</body>

</html>