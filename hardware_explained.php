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
                        <li class="nav-item active"><a class="nav-link" href="#"><i class="fas fa-question fa-fw"></i>What is hardware?</a></li>
                        <li class="nav-item"><a class="nav-link" href="hardware_table.php"><i class="fas fa-table fa-fw"></i>Hardware table</a></li>
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
        <div class="container" id="hardwareExplainedHeading">
            <h1 class="text-center">What is hardware?</h1>
            <p>Hardware is best described as any physical component of a computer system that contains a circuit board, integrated circuit, or other types of electronics (and there is a lot, but don’t worry about that). A perfect example of hardware is the
                screen on which you are viewing this awesome website. Whether it be a monitor, tablet, or smartphone, it is hardware. Without any hardware, your computer would not work, at all. The software you use daily would not work either, as they
                too need hardware.</p>
            <p>Below is a list of internal hardware found inside most computers, take a read about some of them if you’d like!</p>


            <!-- ONLY SHOW WHEN VIEWING ON A DESKTOP -->
            <div id="desktopHardwareExplainedPanel">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="list-group" id="hardware-list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-motherboard-list" data-toggle="list" href="#list-motherboard" role="tab" aria-controls="home">
                                <i class="fas fa-chess-board fa-fw"></i>&nbsp; Motherboard
                            </a>
                            <a class="list-group-item list-group-item-action" id="list-cpu-list" data-toggle="list" href="#list-cpu" role="tab" aria-controls="profile">
                                <i class="fas fa-microchip fa-fw"></i>&nbsp; Central Processing Unit
                            </a>
                            <a class="list-group-item list-group-item-action" id="list-ram-list" data-toggle="list" href="#list-ram" role="tab" aria-controls="messages">
                                <i class="fas fa-memory fa-fw"></i>&nbsp; Random Access Memory
                            </a>
                            <a class="list-group-item list-group-item-action" id="list-gpu-list" data-toggle="list" href="#list-gpu" role="tab" aria-controls="settings">
                                <i class="fas fa-desktop fa-fw"></i>&nbsp; Graphical Processing Unit
                            </a>
                            <a class="list-group-item list-group-item-action" id="list-hdd-list" data-toggle="list" href="#list-hdd-ssd" role="tab" aria-controls="settings">
                                <i class="fas fa-hdd fa-fw"></i></i>&nbsp; Hard Disk & Solid State Drives
                            </a>
                            <br>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="list-motherboard" role="tabpanel" aria-labelledby="list-motherboard-list">
                                <div class="card">
                                    <div class="card-img-overlay">
                                        <p><span>Source: <a href="https://buildyourfuture.withgoogle.com/programs/hps/" target="_blank">Google - Build your future</a></span></p>
                                    </div>
                                    <img class="card-img-top" src="img\motherboard.jpg" alt="Image of a motherboard">
                                    <div class="card-body">
                                        <h5 class="card-title">Motherboard</h5>
                                        <p class="card-text">A motherboard is a printed circuit board that is found within a computer. Its main jobs are to allocate power and allow communication to and from the central processing unit (CPU), random access memory (RAM), and
                                            all other computer hardware components. There are multiple types of motherboards, designed to fit different types and sizes of computers.</p>
                                        <p class="card-text">Your typical motherboard will have the following on it:</p>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Component</th>
                                                    <th scope="col">Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>CMOS battery</td>
                                                    <td>Standing for Complementary Metal Oxide Semi-Conductor, it is responsible for keeping all the information intact when the entire system is shut down.</td>
                                                </tr>
                                                <tr>
                                                    <td>SATA connector</td>
                                                    <td>Serial Advanced Technology Attachment is the standard connector with a 7-pin interface used for connecting storage devices. Despite having 33 fewer pins, this is faster than the old IDE connectors.</td>
                                                </tr>
                                                <tr>
                                                    <td>ATX connector </td>
                                                    <td>The Advanced Technology <span>eXtended</span> connector is the largest connector on the motherboard, as this draws out the needed power directly from the power supply.</td>
                                                </tr>
                                                <tr>
                                                    <td>Front I/O connectors</td>
                                                    <td>Deals with connections to the Power Switch, LED power indicator, Reset Switch, and the HDD LED cables. The front audio port and front USB are also connected here.</td>
                                                </tr>
                                                <tr>
                                                    <td>CPU socket</td>
                                                    <td>Houses a CPU (processor) is installed. This is where the processing and transfer of data happens.</td>
                                                </tr>
                                                <tr>
                                                    <td>Expansion slots</td>
                                                    <td>Allows extra components such as a video card, network card, audio card, or PCIe SSD to be installed.</td>
                                                </tr>
                                                <tr>
                                                    <td>RAM slots</td>
                                                    <td>Slots where RAM modules are placed. There is the SIMM slot (Single in-line memory module) that only supports a 32-bit bus, and there is the DIMM slot (Dual inline memory module) that can simultaneously
                                                        run with a 64-bit bus.</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="card-text">Each type of motherboard is designed to work with specific types of processors and memory, so they are not capable of working with every processor and type of memory. However, hard drives are mostly universal and
                                            work with most motherboards, regardless of the type or brand.</p>
                                        <p class="card-text">These days, most motherboards are built with a modular design in mind. They have on them many different ports that can be used to plug in whatever devices that are needed for the computer. These parts can also be
                                            replaced easily when needed.</p>
                                        <p class="card-text">Most of the devices that you use have a motherboard in them, such as your phones, tablets, laptops, handheld gaming consoles etc. These use a type of motherboard called a logic board. A logic board is very similar
                                            to a motherboard and operates the same way. However, because of size requirements with most logic boards, many components (like the central processing unit and random access memory) are soldered onto the board.
                                            Also, because many of these devices have no upgrade options, there are no slots or sockets like a traditional computer motherboard.</p>
                                        </p>
                                        <div class="card-text" id="hardwareSources">
                                            <p>Sources</p>
                                            <ul class="fa-ul">
                                                <li><span class="fa-li"><i class="fas fa-chess-board"></i></span><a href="https://www.computerhope.com/jargon/m/mothboar.htm" target="_blank">https://www.computerhope.com/jargon/m/mothboar.htm</a></li>
                                                <li><span class="fa-li"><i class="fas fa-chess-board"></i></span><a href="https://www.tomshardware.com/uk/reviews/motherboard-parts-explained,5669.html" target="_blank">https://www.tomshardware.com/uk/reviews/motherboard-parts-explained,5669.html</a></li>
                                                <li><span class="fa-li"><i class="fas fa-chess-board"></i></span><a href="https://www.kencorner.com/computer-motherboard-components/" target="_blank">https://www.kencorner.com/computer-motherboard-components/</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-cpu" role="tabpanel" aria-labelledby="list-cpu-list">
                                <div class="card">
                                    <img class="card-img-top" src="img\cpu.jpg" alt="Image of a CPU">
                                    <div class="card-img-overlay">
                                        <p><span>Source: <a href="https://networkbees.com/what-is-a-processor/" target="_blank">Network Bees</a></span></p>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">Central Processing Unit</h5>
                                        <p class="card-text">The Central Processing Unit (CPU) is an important electronic component on a computer. Described as the heart of the computer, it is where basic logical, arithmetic, input/output (I/O) and control operations are
                                            carried out. This is what allows various programs to be executed. The CPUs that are on most computers are typically housed on single chips that are known as microprocessors. CPUs are complex devices, which are
                                            made up of billions of transistors.</p>
                                        <p class="card-text">CPUs are made up of different components:</p>
                                        <h6 class="card-tltle">Control Unit (CU)</h6>
                                        <p>The control units provides several functions, including:</p>
                                        <ul class="fa-ul">
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>fetching, decoding and executing instructions.</li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>issuing control signals that control hardware.</li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>moving data around the system.</li>
                                        </ul>
                                        <h6 class="card-tltle">Arithmetic Logic Unit (ALU)</h6>
                                        <p>The arithmetic logic unit have two main functions:</p>
                                        <ul class="fa-ul">
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>It performs arithmetic and logical operations (decisions). The ALU is where calculations are done and where decisions are made.</li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>It acts as a gateway between primary memory and secondary storage . Data transferred between them passes through the ALU.</li>
                                        </ul>
                                        <h6 class="card-tltle">Registers</h6>
                                        <p class="card-text">Registers are small amounts of high-speed memory contained within the CPU. They are used by the processor to store small amounts of data that are needed during processing, such as:</p>
                                        <ul class="fa-ul">
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>the address of the next instruction to be executed</li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>the current instruction being decoded</li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>the results of calculations</li>
                                        </ul>
                                        <p class="card-text">Different processors have different numbers of registers for different purposes, but most have some, or all, of the following:</p>
                                        <ul class="fa-ul">
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>Program Counter </li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>Memory Address Register (MAR) </li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>Memory Data Register (MDR) </li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>Current Instruction Register (CIR)</li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>Accumulator (AC)</li>
                                        </ul>
                                        <h6 class="card-tltle">Cache</h6>
                                        <p class="card-text">Cache is a small amount of high-speed random access memory (RAM) built directly within the processor. It is used to temporarily hold data and instructions that the processor is likely to reuse. This allows for faster
                                            processing as the processor does not have to wait for the data and instructions to be fetched from the RAM.</p>
                                        <h6 class="card-tltle">Buses</h6>
                                        <p>A bus is a high-speed internal connection. Buses are used to send control signals and data between the processor and other components. Three types of bus are used:</p>
                                        <ul class="fa-ul">
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>Address bus - carries memory addresses from the processor to other components such as primary memory and input/output devices.</li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>Data bus - carries the actual data between the processor and other components.</li>
                                            <li><span class="fa-li"><i class="fas fa-microchip"></i></span>Control bus - carries control signals from the processor to other components. The control bus also carries the clock's pulses.</li>
                                        </ul>
                                        <h6 class="card-tltle">Clock</h6>
                                        <p class="card-text">The CPU contains a clock which is used to coordinate all of the computer's components. The clock sends out a regular electrical pulse which synchronises (keeps in time) all the components. The frequency of the pulses
                                            is known as the clock speed. Clock speed is measured in hertz. The higher the frequency, the more instructions can be performed in any given moment of time. These cycles can consist of opening a document, loading
                                            a web page, completing a calculation etc.</p>
                                        <div class="card-text" id="hardwareSources">
                                            <p>Sources</p>
                                            <ul class="fa-ul">
                                                <li><span class="fa-li"><i class="fas fa-microchip"></i></span><a href="https://www.bbc.co.uk/bitesize/guides/z7qqmsg/revision/4" target="_blank">https://www.bbc.co.uk/bitesize/guides/z7qqmsg/revision/4</a></li>
                                                <li><span class="fa-li"><i class="fas fa-microchip"></i></span><a href="https://networkbees.com/what-is-a-processor/" target="_blank">https://networkbees.com/what-is-a-processor/</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-ram" role="tabpanel" aria-labelledby="list-ram-list">
                                <div class="card">
                                    <div class="card-img-overlay">
                                        <p><span>Source: <a href="https://www.altomdata.dk/ram-stortest-faa-fart-over-feltet-med-den-bedste-ram-til-gaming/" target="_blank">Alt om DATA</a></span></p>
                                    </div>
                                    <img class="card-img-top" src="img\ram.jpg" alt="Image of a module of RAM">
                                    <div class="card-body">
                                        <h5 class="card-title">Random Access Memory</h5>
                                        <p>Computer memory (known technically as Random Access Memory - RAM) is your computer’s short-term data storage. It stores the information your computer is actively using so that it can be accessed quickly. In a way,
                                            memory is like your desk. It allows you to work on a variety of projects, and the larger your desk, the more papers, folders, and tasks you can have out at one time.</p>
                                        <p>RAM allows your computer to perform many of its everyday tasks, such as loading applications, browsing the internet, editing a spreadsheet, or experiencing the latest game. Memory also allows you to switch quickly
                                            among these tasks, remembering where you are in one task when you switch to another task. As a rule, the more memory you have, the better.</p>
                                        <p>There are different kinds of RAM that are used for different purposes:</p>
                                        <ul class="fa-ul">
                                            <li><span class="fa-li"><i class="fas fa-memory"></i></span>DRAM is the most common kind of RAM; it stands for Dynamic Random Access Memory. The dynamic part comes from the data being refreshed constantly.</li>
                                            <li><span class="fa-li"><i class="fas fa-memory"></i></span>SRAM, or Static Random Access Memory, is called static as it indicates that the information does not need to be refreshed. SRAM is faster, but also more
                                                expensive.
                                            </li>
                                        </ul>
                                        <p>Both kinds of RAM are volatile, that is the information they contain is not saved when the power is turned off to the computer.</p>
                                        <p>Computer manufacturers often fail to fully populate the installed memory capacity in the systems they sell because they want to keep the price down. For example, if a desktop can hold 32GB of RAM, it often comes
                                            with 4GB or 8GB. With plenty of space for more memory, an upgrade is not only easy, it will provide a measurable boost in performance. There is almost always room to improve.</p>
                                        <div class="card-text" id="hardwareSources">
                                            <p>Sources</p>
                                            <ul class="fa-ul">
                                                <li><span class="fa-li"><i class="fas fa-microchip"></i></span><a href="https://uk.crucial.com/articles/about-memory/support-what-does-computer-memory-do" target="_blank">https://uk.crucial.com/articles/about-memory/support-what-does-computer-memory-do</a></li>
                                                <li><span class="fa-li"><i class="fas fa-microchip"></i></span><a href="https://uk.crucial.com/articles/about-memory/how-much-ram-does-my-computer-need" target="_blank">https://uk.crucial.com/articles/about-memory/how-much-ram-does-my-computer-need</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-gpu" role="tabpanel" aria-labelledby="list-gpu-list">
                                <div class="card">
                                    <div class="card-img-overlay">
                                        <p><span>Source: <a href="https://www.gamesbap.com/what-is-a-graphics-card/" target="_blank">Gamesbap</a></span></p>
                                    </div>
                                    <img class="card-img-top" src="img\gpu.png" alt="Image of a module of RAM">
                                    <div class="card-body">
                                        <h5>Graphics Processing Unit</h5>
                                        <p>A Graphics Processing Unit (GPU) is used for rendering images from the computer to output onto a monitor. This is done by converting the data that the computer processes to a digital or analogue signal which can
                                            be displayed on the monitor. All computers will come with a GPU, but not all will be suitable for more demanding tasks such as playing games, or video rendering.</p>
                                        <p>There are two main types of graphical processing units.</p>
                                        <h6>Integrated GPU</h6>
                                        <p>Integrated GPUs are built in on your motherboard as a part of the chipset, or in your CPU. It’s very important to know that not every CPU has this feature and some CPUs can only be used strictly as CPUs. However,
                                            if your CPU has an integrated graphics card, it will allow you to complete basic tasks that do not require extensive use of graphics. Newer CPUs have integrated GPUs that do allow users to play graphically intensive
                                            games at a lower resolution, but typically they are only used for web browsing, watching videos, and general PC use.</p>
                                        <h6>Dedicated GPU</h6>
                                        <p>Dedicated GPUs are much more powerful, and they are here for various purposes. Years ago, GPUs were primarily used for gaming, rendering and working in some graphically intensive environments. However, the technology
                                            allowed us to do much more with our graphics chips and now we have GPUs made for specific purposes, such as gaming, rendering, cloud gaming, workstations, and mining. Mining is a very demanding process which
                                            uses all your GPUs power in order to mine a cryptocurrency you want to. In fact, it’s so popular that GPU manufacturers such as Nvidia and AMD both produce graphics cards dedicated to miners.
                                        </p>
                                        <div class="card-text" id="hardwareSources">
                                            <p>Sources</p>
                                            <ul class="fa-ul">
                                                <li><span class="fa-li"><i class="fas fa-desktop"></i></span><a href="https://www.encore-pc.co.uk/blog/graphics-cards-explained/" target="_blank">https://www.encore-pc.co.uk/blog/graphics-cards-explained/</a></li>
                                                <li><span class="fa-li"><i class="fas fa-desktop"></i></span><a href="https://www.gamesbap.com/what-is-a-graphics-card/" target="_blank">https://www.gamesbap.com/what-is-a-graphics-card/</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="list-hdd-ssd" role="tabpanel" aria-labelledby="ist-hdd-list">
                                <div class="card">
                                    <div class="card-img-overlay">
                                        <p><span>Source: <a href="https://www.dignited.com/36069/how-to-know-your-computer-hard-drive-is-failing/" target="_blank">Dignited</a></span></p>
                                    </div>
                                    <img class="card-img-top" src="img\hdd.jpeg" alt="Image of a module of RAM">
                                    <div class="card-body">
                                        <h5>Hard Disk & Solid State Drives</h5>
                                        <p>Hard Disk Drives (HDD) and Solid State Drives (SSD) are a type of non-volatile, long-term storage. Without secondary storage all programs and data would be lost the moment the computer is switched off, so it is
                                            a vital part of any computer.</p>
                                        <h6>Hard Disk Drive</h6>
                                        <p>Hard Disk Drives (HDD) use magnetic fields to magnetise tiny individual sections of a metal spinning disk. Each tiny section represents one bit. A magnetised section represents a binary '1' and a demagnetised section
                                            represents a binary '0'. These sections are so tiny that disks can contain terabytes (TB) of data.</p>
                                        <p>As the disk is spinning, a read/write head moves across its surface. To write data, the head magnetises or demagnetises a section of the disk that is spinning under it. To read data, the head makes a note of whether
                                            the section is magnetised or not.</p>
                                        <p>HDDs are cheap, high in capacity and durable. However, they are susceptible to damage if dropped. They are also vulnerable to magnetic fields - a strong magnet might possibly erase the data the device holds.</p>
                                        <h6>Solid State Drive</h6>
                                        <p>Solid State Drives (SSD) are a special type of storage made from silicon microchips. It can be written to and overwritten like RAM, but unlike RAM, it is non-volatile. This means that when the computer's power is
                                            switched off, SSDs will retain their contents. The technology in SSDs are also used as external secondary storage, for example in USB memory sticks.</p>
                                        <p>One of the major benefits SSDs are that they have no moving parts. Because of this, they are more portable, and produce less heat compared to traditional magnetic storage devices. Less heat means that components
                                            last longer.</p>
                                        <h6>Comparison table</h6>
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th>Solid State Drive</th>
                                                    <th>Hard Disk Drive</th>
                                                </tr>
                                                <tr>
                                                    <td>As they are a newer technology, they are typically expensive to purchase per gigabyte of data.</td>
                                                    <td>Since they are a proven technology, they are a lot cheaper per gigabyte of data.&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>No mechanical parts means loading speeds are faster, and read and write speeds are quick.</td>
                                                    <td>Due to using mechanical parts, it takes a longer period of time to read and write data to the disk.</td>
                                                </tr>
                                                <tr>
                                                    <td>They are much lighter and are better able to withstand movement and droppages.</td>
                                                    <td>Dropping the drive can damage it and risk all data on it being lost. They are also a lot heavier.</td>
                                                </tr>
                                                <tr>
                                                    <td>They use less energy, allowing computers to run cooler, which is a major benefit to laptops.</td>
                                                    <td>They use a lot more energy, draining laptop batteries much faster, and requires more power to cool them down.&nbsp;</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="card-text" id="hardwareSources">
                                            <p>Sources</p>
                                            <ul class="fa-ul">
                                                <li><span class="fa-li"><i class="fas fa-hdd"></i></span><a href="https://uk.crucial.com/articles/about-ssd/what-is-an-SSD" target="_blank">https://uk.crucial.com/articles/about-ssd/what-is-an-SSD</a></li>
                                                <li><span class="fa-li"><i class="fas fa-hdd"></i></span><a href="https://www.computerhope.com/jargon/h/harddriv.htm" target="_blank">https://www.computerhope.com/jargon/h/harddriv.htm</a></li>
                                                <li><span class="fa-li"><i class="fas fa-hdd"></i></span><a href="https://www.crucial.com/articles/about-ssd/ssd-vs-hdd#" target="_blank">https://www.crucial.com/articles/about-ssd/ssd-vs-hdd#</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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

    <div class="modal fade" id="modalAccountCreated" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="container">
                    <h3 class="text-center">Account created!</h3>
                    <p class="text-center">You can now log in to your new account. Enjoy!</p>
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