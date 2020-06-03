/**
 * Deals with the validation of forms
 *  Title: Bootstrap Forms - Custom styles
 *  Author: Bootstrap
 *  Date: 2020
 *  Availability: https://getbootstrap.com/docs/4.0/components/forms/#custom-styles
 */
(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

/**
 * Deals with the submission of the registraton form
 */
$(function() {
    $("#form-createAccount").submit(function(event) {

        //If the form is not valid, exit
        if (this.checkValidity() === false) {
            return;
        }

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
        var request;
        var form = $(this);

        // Abort any pending request
        if (request) {
            request.abort();
        }

        // Get values from the form
        var firstname = $('#inputFirstName').val();
        var surname = $('#inputSurname').val();
        var email = $('#inputEmail').val();
        var username = $('#inputUsername').val();
        var password = $('#inputPassword').val();

        /* Checks to see if reCAPTCHA is created
         *  Title: reCAPTCHA v2
         *  Author: Google
         *  Date: 2020
         *  Available: https://developers.google.com/recaptcha/docs/display
         */
        if (grecaptcha === undefined) {
            Swal.fire({
                icon: 'error',
                title: 'Well ****',
                message: 'The reCAPTCHA does not exist for some reason. Refresh the page and try again. Sorry!',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        }

        // Gets the response of the reCAPTCHA
        var response = grecaptcha.getResponse();

        // If it is null, tell the user to check the box
        if (!response) {
            Swal.fire({
                icon: 'error',
                title: 'Are you a robot?',
                text: 'You need to check the box so we can ensure you are in fact a real person!',
                showConfirmButton: false,
                timer: 3000
            });
            return;
        }

        // Disable the inputs for the duration of the Ajax request.
        var inputs = form.find("input");
        inputs.prop("disabled", true);

        // Fire off the request to accountdb.php
        request = $.ajax({
            url: "php/accountdb.php",
            type: "post",
            data: {
                firstname: firstname,
                surname: surname,
                email: email,
                username: username,
                password: password,
                form: 'createAccount',
                recaptcha: response
            }
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            // Report based on outcome
            if (response.includes("username")) {
                //The username is taken, so set it to invalid. The request was blocked in PHP.
                if (grecaptcha === undefined) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Are you a robot?',
                        text: 'You need to check the box so we can ensure you are in fact a real person!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    return;
                }
            }
            if (response.includes("Yes")) {
                Swal.fire({
                    icon: 'success',
                    title: 'Account created, you can now log in!',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        $('#modalCreateAccount').modal('toggle');
                    }
                })
            }
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function() {
            // Reenable the inputs
            inputs.prop("disabled", false);
        });

    });
});

/**
 * Deals with the login of a user
 */
$(function() {
    $("#form-signin").submit(function(event) {

        //If the form is not valid, exit
        if (this.checkValidity() === false) {
            return;
        }

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
        var request;
        var $form = $(this);

        // Abort any pending request
        if (request) {
            request.abort();
        }

        // Get values from the form
        var username = $('#inputUsernameSignIn').val();
        var password = $('#inputPasswordSignIn').val();

        // Disable the inputs for the duration of the Ajax request.
        var $inputs = $form.find("input");
        $inputs.prop("disabled", true);

        // Fire off the request to accountdb.php
        request = $.ajax({
            url: "php/accountdb.php",
            type: "post",
            data: {
                username: username,
                password: password,
                form: 'loginAccount'
            }
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            // Report based on outcome
            if (response.includes("No account")) {
                //The username is taken, so set it to invalid. The request was blocked in PHP.
                Swal.fire({
                    icon: 'error',
                    title: 'We couldn\'t log you in',
                    text: 'We could not find an account with them details',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
            if (response.includes("Yes")) {
                Swal.fire({
                    icon: 'success',
                    title: 'Logged in!',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.reload(true);
                    }
                })
            }
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function() {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });
    });
});

/**
 * Deals with logging out a user
 */
$(function() {
    $("#logOutLink").click(function(event) {
        request = $.ajax({
            url: "php/accountdb.php",
            type: "post",
            data: {
                form: 'logout'
            }
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            //Put them back on the homepage.
            window.location.replace('index.php');
        });

    });
});

/**
 * Deals with user account settings
 */
$(function() {
    $('#formEmailChange').submit(function(event) {
        //If the form is not valid, exit
        if (this.checkValidity() === false) {
            return;
        }

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
        var request;
        var $form = $(this);

        // Abort any pending request
        if (request) {
            request.abort();
        }

        // Get values from the form
        var email = $('#changeEmail').val();

        // Disable the inputs for the duration of the Ajax request.
        var $inputs = $form.find("input");
        $inputs.prop("disabled", true);

        // Fire off the request to accountdb.php
        request = $.ajax({
            url: "php/accountdb.php",
            type: "post",
            data: {
                email: email,
                form: 'changeEmail'
            }
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            if (response.includes("Yes")) {
                Swal.fire({
                    icon: 'success',
                    title: 'Your email has been changed!',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.reload(true);
                    }
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Your email wasn\'t changed',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.reload(true);
                    }
                })
            }
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });
    });

    $('#formPasswordChange').submit(function(event) {
        //If the form is not valid, exit
        if (this.checkValidity() === false) {
            return;
        }

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
        var request;
        var $form = $(this);

        // Abort any pending request
        if (request) {
            request.abort();
        }

        // Get values from the form
        var passOld = $('#changePasswordCurrent').val();
        var passNew = $('#changePasswordNew').val();

        // Check if they are the same and if so, just reject it
        if (passOld == passNew) {
            Swal.fire({
                icon: 'question',
                title: 'Why do you want to change your password when it is the same as the one you currently have?',
            });

            return;
        }

        // Disable the inputs for the duration of the Ajax request.
        var $inputs = $form.find("input");
        $inputs.prop("disabled", true);

        // Fire off the request to accountdb.php
        request = $.ajax({
            url: "php/accountdb.php",
            type: "post",
            data: {
                passOld: passOld,
                passNew: passNew,
                form: 'changePassword'
            }
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            if (response.includes("Yes")) {
                Swal.fire({
                    icon: 'success',
                    title: 'Your password has been changed!',
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.reload(true);
                    }
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Your password wasn\'t changed',
                    text: response
                });
                $inputs.prop("disabled", false);
            }
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });
    });

    $('#clearLoginHistorybtn').click(function() {
        request = $.ajax({
            url: "php/accountdb.php",
            type: "post",
            data: {
                form: 'clearLoginHistory'
            }
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            if (response.includes("cleared!")) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response,
                    showConfirmButton: false,
                    timer: 1500
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        location.reload(true);
                    }
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Something went wrong',
                    text: response
                });
                $inputs.prop("disabled", false);
            }
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });
    });

    $('#deleteAccountbtn').click(function() {
        Swal.fire({
            title: 'Is this a goodbye?',
            text: "You won't be able to revert this, so only go ahead if you are really sure!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                //Delete the account
                request = $.ajax({
                    url: "php/accountdb.php",
                    type: "post",
                    data: {
                        form: 'deleteAccount'
                    }
                });

                // Callback handler that will be called on success
                request.done(function(response, textStatus, jqXHR) {
                    if (response.includes("Your account was deleted")) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success :(',
                            text: response,
                            showConfirmButton: false,
                            timer: 5000
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                //Put them back on the homepage.
                                window.location.replace('index.php');
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something went wrong',
                            text: response
                        });
                    }
                });
            }
        })
    });
});

/**
 * Loads in all rows from the 'HardwareTable' table in the database
 */
$(function() {
    if (top.location.pathname === '/student/adbb026/hardware_table.php') {
        // Fire off the request to hardwaredb.php to possibly load in user hardware
        request = $.ajax({
            url: "php/hardwaredb.php",
            type: "post",
            data: {
                window: 'hardwaretable'
            },
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            //Parse the data as a JSON structure
            var tableJSON = JSON.parse(response);
            console.log(tableJSON);

            //Loop trough the JSON array and put data into the table
            tableJSON.forEach(function(obj) {
                //If the HardwareName variable is null, loop to the next item in the array
                if (obj.HardwareName != 0) {
                    //Create the table row
                    var tblRow;

                    tblRow = "<tr data-toggle=\"modal\" data-target=\"#modalShowUserHardwareExplained\"><th scope=\"row\">" + obj.Username + "</th>";
                    tblRow += "<td>" + obj.OS + " (" + obj.OSArchitecture + ")</td>";
                    tblRow += "<td>" + obj.CPU + "</td>";

                    //Add GPUs to the row
                    tblRow += "<td>"
                    var gpus = [];
                    obj.GPU.forEach(function(obj) {
                        gpus.push(obj.name);
                    });
                    tblRow += gpus.join(",<br>");
                    tblRow += "</td>"

                    tblRow += "<td>" + obj.RAM + "GB</td>";

                    //Add drives to the row
                    tblRow += "<td>"
                    var drives = [];
                    obj.Drive.forEach(function(obj) {
                        drives.push(obj.size + "GB " + obj.type)
                    });
                    tblRow += drives.join(",<br>");
                    tblRow += "</td>"

                    //Complete the row
                    tblRow += "</tr>";

                    //If the row is related to the logged in user, then show it at the top highlighted blue
                    if ($('#mainNavbar > ul > li:nth-child(4) > a').text().includes(obj.Username)) {
                        tblRow = tblRow.replace("<tr", "<tr class=\"table-info\"");
                        $(tblRow).prependTo('#tableHardwareDatabase > tbody');
                        //$('#tableHardwareDatabase > tbody:first-child').prepend(tblRow);
                    } else {
                        $('#tableHardwareDatabase > tbody:last-child').append(tblRow);
                    }
                }
            });
        });
    }
});

/**
 * Gets details on a user's hardware using the following:
 * 
 * ADD LATER ON
 */
$(function() {
    $("body").delegate("#tableHardwareDatabase > tbody > tr", "click", function() {
        var cpuRequest = new XMLHttpRequest();

        //USER DATA//
        //Start by looping through all td's to get the data
        var rowData = $('td', this).map(function(index, td) {
            return $(td).text();
        });

        //Split the gpu and drive values into lists
        var gpuList = rowData[2].split(',');
        var driveList = rowData[4].split(',');

        //Work out how many things we need to progress through
        var progressValue = 0;
        var progressIncrement = 100 / (gpuList.length + 2);


        //Set the title of the card
        $('#modalShowUserHardwareExplained > div > div > div.modal-header > h5').text($(this).find('th').text() + "'s Hardware Explained");

        //OPERATING SYSTEM CARD//
        $('#hardwareCardExplainOperatingSystem > div.card-body > h5').text(rowData[0]);

        //Read in the json from the server and then populate the card
        $.get("txt/osList.json", function(data) {
            data.forEach(function(obj) {
                if (rowData[0].includes(obj.name)) {
                    $('#hardwareCardExplainOperatingSystem > img').attr('src', obj.filename);
                    $('#hardwareCardExplainOperatingSystem > div.card-img-overlay > p > span > a').attr('href', obj.imgsource);
                    $('#hardwareCardExplainOperatingSystem > div.card-body > p').text(obj.description);

                    //Update the value of the progress bar
                    progressValue += progressIncrement;
                    $('.progress-bar').css('width', progressValue + '%').attr('aria-valuenow', progressValue);
                }
            })
        });

        //CPU CARD//
        $('#hardwareCardExplainCPU > div.card-body > h5').text(rowData[1]);

        /*
         * Title: Webscraping without Node js possible?
         * Author: wizzwizz4
         * Date: 2020
         * Available: https://stackoverflow.com/questions/55664259/webscraping-without-node-js-possible
         */
        cpuRequest.open("GET", "https://cors-anywhere.herokuapp.com/" + "https://en.wikichip.org/wiki/" + rowData[1], true);
        cpuRequest.responseType = "document";
        cpuRequest.onload = function(e) {
            if (cpuRequest.readyState === 4) {
                if (cpuRequest.status === 200) {
                    //Get the information needed
                    var cpuIntroPara = cpuRequest.responseXML.querySelector("#mw-content-text > p:nth-child(2)");
                    cpuIntroPara = $(cpuIntroPara).text().split('.')[0] + ".";
                    var cpuImage = cpuRequest.responseXML.querySelector("#mw-content-text > table.infobox > tbody > tr:nth-child(3) > td > img");
                    cpuImage = "https://en.wikichip.org" + $(cpuImage).attr('src');

                    var infoBox = cpuRequest.responseXML.querySelector('#mw-data-after-content > div > table > tbody');
                    var cpuReleaseDate, cpuReleasePrice, cpuArchitecture, cpuFrequency, cpuTurboFrequency, cpuProcess, cpuCoreCount;

                    for (var i = 0; row = infoBox.rows[i]; i++) {
                        var property = row.cells[0].innerHTML;

                        if (property.includes("first launched") && cpuReleaseDate == null) {
                            cpuReleaseDate = row.cells[1].textContent.replace("+", "").trim();
                            console.log(cpuReleaseDate);
                        }
                        if (property.includes("release price") && cpuReleasePrice == null) {
                            cpuReleasePrice = row.cells[1].textContent.replace("+", "").replace(/ *\([^)]*\) */g, "").replace(/\s/g, '').trim();
                            console.log(cpuReleasePrice);
                        }
                        if (property.includes("microarchitecture") && cpuArchitecture == null) {
                            cpuArchitecture = row.cells[1].textContent.replace("+", "").trim();
                            console.log(cpuArchitecture);
                        }
                        if (property.includes("base frequency") && cpuFrequency == null) {
                            cpuFrequency = row.cells[1].textContent.replace("+", "").replace(/z,.*\)/g, "z)").replace(",", "").trim();
                            console.log(cpuFrequency);
                        }
                        if (property.includes("turbo frequency") && cpuTurboFrequency == null) {
                            cpuTurboFrequency = row.cells[1].textContent.replace("+", "").replace(/z,.*\)/g, "z)").replace(",", "").trim();
                            console.log(cpuTurboFrequency);
                        }
                        if (property.includes("process") && cpuProcess == null) {
                            cpuProcess = row.cells[1].textContent.replace("+", "").replace(/ *\([^)]*\) */g, "").trim();
                            console.log(cpuProcess);
                        }
                        if (property.includes("core count") && cpuCoreCount == null) {
                            cpuCoreCount = row.cells[1].textContent.replace("+", "").trim();
                        }
                    }

                    //Add this information to the card
                    if (!(cpuImage.includes("undefined"))) $('#hardwareCardExplainCPUImage').attr('src', cpuImage);
                    $('#hardwareCardExplainCPUParagraph').text(cpuIntroPara);
                    $('#hardwareCardExplainCPUTable > tbody:last-child').append('<tr><th><span data-toggle="tooltip" title="The official release date of the CPU.">Launch date&nbsp;</span></th><td>' + cpuReleaseDate + '</td></tr>');
                    if (cpuReleasePrice != null) { $('#hardwareCardExplainCPUTable > tbody:last-child').append('<tr><th><span data-toggle="tooltip" title="The official price of the CPU on launch.">Release price&nbsp;</span></th><td>' + cpuReleasePrice + '</td></tr>'); }
                    $('#hardwareCardExplainCPUTable > tbody:last-child').append('<tr><th><span data-toggle="tooltip" title="The codename used for the series this CPU was made for.">Codename&nbsp;</span></th><td>' + cpuArchitecture + '</td></tr>');
                    $('#hardwareCardExplainCPUTable > tbody:last-child').append('<tr><th><span data-toggle="tooltip" title="The number of independent central processing units in a single computing component.">Core count&nbsp;</span></th><td>' + cpuCoreCount + '</td></tr>');
                    $('#hardwareCardExplainCPUTable > tbody:last-child').append('<tr><th><span data-toggle="tooltip" title="The guaranteed maximum clock speed for when the CPU is under full utilization.">Base frequency&nbsp;</span></th><td>' + cpuFrequency + '</td></tr>');
                    $('#hardwareCardExplainCPUTable > tbody:last-child').append('<tr><th><span data-toggle="tooltip" title="The potential maximum clock speed for a CPU under full utilization.">Turbo frequency&nbsp;</span></th><td>' + cpuTurboFrequency + '</td></tr>');
                    $('#hardwareCardExplainCPUTable > tbody:last-child').append('<tr><th><span data-toggle="tooltip" title="Refers to the semiconductor technology used to manufacture the integrated circuit, indicative of the size of features built on the semiconductor.">Lithography&nbsp;</span></th><td>' + cpuProcess + '</td></tr>');

                    //Update the value of the progress bar
                    progressValue += progressIncrement;
                    $('.progress-bar').css('width', progressValue + '%').attr('aria-valuenow', progressValue);

                    //Toggle tooltips otherwise they do not work
                    $('[data-toggle="tooltip"]').tooltip();
                } else {
                    console.error(cpuRequest.status, cpuRequest.statusText);
                }
            }
        };
        cpuRequest.onerror = function(e) {
            console.error(cpuRequest.status, cpuRequest.statusText);
        };
        cpuRequest.send(null); // not a POST request, so don't send extra data

        //GPU CARDS//
        gpuList.forEach(function(element, index) {
            //If not the first index, clone the gpu card
            if (index != 0) {
                var newGPU = $('#hardwareCardExplainGPU1').clone().prop('id', 'hardwareCardExplainGPU' + (index + 1));
                newGPU.insertAfter('#hardwareCardExplainGPU1');
            }
        });

        gpuList.forEach(function(element, index) {
            //Url for the GPU
            var gpuUrl;

            //Strip all branding and add url space characters
            element = element.replace("NVIDIA ", "").replace("AMD ", "");
            var gpu = element.replace(/\s/g, '%20');

            //Find the GPU
            $.ajax({
                url: "https://cors-anywhere.herokuapp.com/https://www.techpowerup.com/gpu-specs/?ajaxsrch=" + gpu,
                headers: {
                    "x-requested-with": "xhr"
                },
                type: 'GET',
                dataType: 'xml',
            }).done(function(data) {
                $(data).each(function() {
                    $(this).find('tr').each(function() {
                        if ($(this).find('td:nth-child(1)').text().trim() == element) {
                            //We found the GPU, now go to its page and get the data
                            gpuUrl = 'https://cors-anywhere.herokuapp.com/https://www.techpowerup.com' + $(this).find('td:nth-child(1) > a').attr("href");
                            console.log(gpuUrl);
                        }
                    })
                })

                //Get the GPU's details
                $.ajax({
                    url: gpuUrl,
                    headers: {
                        "x-requested-with": "xhr"
                    },
                    type: 'GET',
                    dataType: 'html'
                }).done(function(data) {
                    var GPUImg, GPUDesc, GPURelease, GPUMemory, GPUBaseClock, GPUBoostClock, GPUCores, GPUtmu, GPUrop;

                    //Set the variables
                    GPUImg = $(data).find('#page > article > div.gpudb-large-image__wrapper > a:nth-child(1) > img').attr('src');
                    GPUDesc = $(data).find('#page > article > div.desc.p').text().split('.')[0] + ".".trim();
                    GPURelease = $(data).find('#page > article > div.sectioncontainer > section:nth-child(2) > div > dl:nth-child(1) > dd').text().trim();
                    GPUMemory = $(data).find('#page > article > div.sectioncontainer > section:nth-child(5) > div > dl:nth-child(1) > dd').text().trim();
                    GPUBaseClock = $(data).find('#page > article > div.sectioncontainer > section:nth-child(4) > div > dl:nth-child(1) > dd').text().trim();
                    GPUBoostClock = $(data).find('#page > article > div.sectioncontainer > section:nth-child(4) > div > dl:nth-child(2) > dd').text().trim();
                    GPUCores = $(data).find('#page > article > dl > div:nth-child(2) > dd').text().trim();
                    GPUtmu = $(data).find('#page > article > dl > div:nth-child(3) > dd').text().trim();
                    GPUrop = $(data).find('#page > article > dl > div:nth-child(4) > dd').text().trim();

                    //Add them to the card
                    var gpuCardID = "#hardwareCardExplainGPU" + (index + 1);
                    $(gpuCardID + " > img").attr('src', GPUImg);
                    $(gpuCardID + " > div > h5").text(element);
                    $(gpuCardID + " > div > p").text(GPUDesc);
                    $(gpuCardID + " > div > div > table > tbody:last-child").append('<tr><th><span data-toggle="tooltip" title="The official release date of the GPU.">Launch date</span></th><td>' + GPURelease + '</td></tr>');
                    $(gpuCardID + " > div > div > table > tbody:last-child").append('<tr><th><span data-toggle="tooltip" title="The total memory size on the GPU itself. This is not to be confused with RAM.">Memory</span></th><td>' + GPUMemory + '</td></tr>');
                    $(gpuCardID + " > div > div > table > tbody:last-child").append('<tr><th><span data-toggle="tooltip" title="The guaranteed maximum clock speed for when the GPU is under full utilization.">Base Clock</span></th><td>' + GPUBaseClock + '</td></tr>');
                    $(gpuCardID + " > div > div > table > tbody:last-child").append('<tr><th><span data-toggle="tooltip" title="The potential maximum clock speed for when the CPU is under full utilization.">Boost Clock</span></th><td>' + GPUBoostClock + '</td></tr>');
                    $(gpuCardID + " > div > div > table > tbody:last-child").append('<tr><th><span data-toggle="tooltip" title="The number of independent cores in a GPU. More cores means more multi-tasking can occur.">Cores</span></th><td>' + GPUCores + '</td></tr>');
                    $(gpuCardID + " > div > div > table > tbody:last-child").append('<tr><th><span data-toggle="tooltip" title="A TMU can rotate, resize, and distort a bitmap image to be placed onto a single plane of a 3D model as a texture.">TMUs</span></th><td>' + GPUtmu + '</td></tr>');
                    $(gpuCardID + " > div > div > table > tbody:last-child").append('<tr><th><span data-toggle="tooltip" title="ROPs handle anti-aliasing, Z and color compression, and the actual writing of a pixel to the output buffer ready to be displayed on screen.">ROPs</span></th><td>' + GPUrop + '</td></tr>');

                    //Update the value of the progress bar
                    progressValue += progressIncrement;
                    $('.progress-bar').css('width', progressValue + '%').attr('aria-valuenow', progressValue);

                    //Toggle tooltips otherwise they do not work
                    $('[data-toggle="tooltip"]').tooltip();
                });
            });
        });
    });
});

/**
 * Clear hardware expalined modal on close
 */
$(function() {
    $('#modalShowUserHardwareExplained').on('hidden.bs.modal', function() {
        $('.card-img-top').attr('src', 'img/noimage.png')
        $('.card-text').empty();
        $('.card-body > div > table > tbody').empty();
        $('.card-title').empty();
        $(this).find("#hardwareCardExplainGPU2").remove();
        $(this).find("#hardwareCardExplainGPU3").remove();
        $(this).find("#hardwareCardExplainGPU4").remove();
    });
});

/**
 * Loads in the users previous hardware if it exists
 */
$(function() {
    if (top.location.pathname === '/student/adbb026/user_hardware.php') {
        // Fire off the request to hardwaredb.php to possibly load in user hardware
        request = $.ajax({
            url: "php/hardwaredb.php",
            type: "post",
            data: {
                window: 'loaded'
            },
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            //No record loaded so don't do anything
            if (response.length == 0) {
                $('select.gpuSelect').selectpicker('val', "");
                return;
            }

            //Populate the form
            var formJSON = JSON.parse(response);

            $('#hardwareName').val(formJSON.HardwareName);
            $('#selectpickerOS').selectpicker('val', formJSON.OS);
            $("input[value='" + formJSON.OSArchitecture + "']").prop('checked', true).parent().addClass('active');
            $('#selectpickerCPU').selectpicker('val', formJSON.CPU);
            $('#ramRange').val(formJSON.RAM);
            $('#ramRangeValue').text(formJSON.RAM + "GB");

            //Add the multiple GPUs
            for (var i = 0; i < formJSON.GPU.length - 1; i++) {
                $("#btnAddGpu").trigger("click");
            }

            $('select.gpuSelect').each(function(index, element) {
                $(element).selectpicker('val', formJSON.GPU[index].name);
            });

            //Add the multiple drives
            for (var i = 0; i < formJSON.Drive.length - 1; i++) {
                $("#btnAddDrive").trigger("click");
            }

            $('div[id^=driveRow]').each(function(index, element) {
                $(element).find('#driveSize').val(formJSON.Drive[index].size);
                $(element).find("input[value='" + formJSON.Drive[index].type + "']").prop('checked', true).parent().addClass('active');;
            });

            //Tell the user their record has been loaded
            Swal.fire({
                icon: 'success',
                title: 'Your hardware configuration has been loaded',
                showConfirmButton: false,
                timer: 1500
            })
        });
    }
});

/**
 * Deals with a user submitting their hardware
 */
$(function() {
    $("#form-UserHardware").submit(function(event) {
        //If the form is not valid, exit
        if (this.checkValidity() === false) {
            return;
        }

        // Prevent default posting of form - put here to work in case of errors
        event.preventDefault();
        var request;
        var $form = $(this);

        // Abort any pending request
        if (request) {
            request.abort();
        }

        // GET VALUES FOR THE FORM //
        var hardwareName = $('#hardwareName').val();
        var operatingSystem = $('#selectpickerOS').val();
        var architecture = $("input[name='architectureOptions']:checked").val();
        var cpu = $('#selectpickerCPU').val();
        var ram = $('#ramRangeValue').text();

        //Since there can be 4 GPUs, check and then serialise into a json format
        var gpuArray = [];

        $('[id^="gpuSelector"]').each(function(index) {
            var gpuItem = {}
            gpuItem['name'] = $(this).find('.selectpicker').val()
            gpuArray.push(gpuItem);
        });

        var gpuJSON = JSON.stringify(gpuArray);

        //Since there can be 4 drives, check and then serialise into a json format
        var driveArray = [];

        $('[id^="driveRow"]').each(function(index) {
            console.log($(this));
            var driveItem = {}
            driveItem['size'] = $(this).find('#driveSize').val()
            driveItem['type'] = $(this).find("input[name='driveOptions" + (index + 1) + "']:checked").val();
            driveArray.push(driveItem);
        });

        var driveJSON = JSON.stringify(driveArray);

        // Disable the inputs for the duration of the Ajax request.
        var $inputs = $form.find("input");
        $inputs.prop("disabled", true);

        // Fire off the request to hardwaredb.php
        request = $.ajax({
            url: "php/hardwaredb.php",
            type: "post",
            data: {
                hardwareName: hardwareName,
                os: operatingSystem,
                architecture: architecture,
                cpu: cpu,
                ram: ram,
                gpus: gpuJSON,
                drives: driveJSON
            }
        });

        // Callback handler that will be called on success
        request.done(function(response, textStatus, jqXHR) {
            //Tell the user their hardware has been saved
            Swal.fire({
                icon: 'success',
                title: 'Your hardware configuration has been updated!',
                showConfirmButton: false,
                timer: 1500
            })
        });

        // Callback handler that will be called on failure
        request.fail(function(jqXHR, textStatus, errorThrown) {
            // Log the error to the console
            Swal.fire({
                icon: 'error',
                title: 'Well ****',
                text: 'We could not save your hardware configuration...',
                showConfirmButton: false,
                timer: 1500
            })
        });

        // Callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function() {
            // Reenable the inputs
            $inputs.prop("disabled", false);
        });

    });
});

/**
 * Searches through the hardware table and only shows rows that are valid
 */
$(document).ready(function() {
    $("#hardwareSearchTable").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tableHardwareDatabase > tbody > tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

/** 
 * Sets all tooltips 
 */
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

/**
 * Clears all content in the modal when clicked off
 */
$(document).ready(function() {
    $(".modal").on("hidden.bs.modal", function() {
        // Clear the login and sign up form
        $('#form-signin').trigger("reset");
        $('#form-createAccount').trigger("reset");

        // Reset the reCAPTCHA
        grecaptcha.reset();
    });
});


/**
 * Deals with GPU addition and removal.
 */
$(document).ready(function() {
    $('#btnAddGpu').click(function() {
        //Get number of dropdowns
        var count = $('div[id^=gpuSelector]').length;

        //Clone the gpu dropdown
        var orginal = $('#gpuSelector' + count);
        var cloned = orginal.clone();

        //Change the id of the clones dropdown
        var newID = 'gpuSelector' + (count + 1)
        cloned.prop('id', newID);

        //Set its dropdown items
        cloned.find('.bootstrap-select').replaceWith(function() { return $('select', this); });
        cloned.find('.selectpicker').selectpicker();

        //Add after the correct div
        cloned.insertAfter('#gpuSelector' + count);

        //Increment counter
        count++;

        //Enable removal button
        if (count >= 2) {
            $('#btnRemoveGpu').removeClass('disabled');
            $('#btnRemoveGpu').prop('disabled', false);
        }

        //Disable adding more if count is equal to 4
        if (count == 4) {
            $('#btnAddGpu').addClass('disabled');
            $('#btnAddGpu').prop('disabled', true);
            return;
        }
    });

    $('#btnRemoveGpu').click(function() {
        //Remove the last dropdown
        $('div[id^=gpuSelector]:last').remove();

        //Enable and disable buttons as appropriate
        var count = $('div[id^=gpuSelector]').length;

        if (count == 1) {
            $('#btnRemoveGpu').addClass('disabled');
            $('#btnRemoveGpu').prop('disabled', true);
        }

        //Disable adding more if count is equal to 4
        if (count <= 3) {
            $('#btnAddGpu').removeClass('disabled');
            $('#btnAddGpu').prop('disabled', false);
            return;
        }
    });
});

/**
 * Updates the value of the RAM slider
 */
$(document).ready(function() {
    document.getElementById('ramRange').oninput = function() {
        document.getElementById('ramRangeValue').innerHTML = this.value + "GB";
    }
});

/**
 * Deals with Drive addition and removal
 */
$(document).ready(function() {
    $('#btnAddDrive').click(function() {
        //Get number of drives
        var count = $('div[id^=driveRow]').length;

        //Clone the drive row
        var orginal = $('#driveRow' + count);
        var cloned = orginal.clone();

        //Change the id of the cloned drive row and radio buttons
        var newID = 'driveRow' + (count + 1);
        cloned.prop('id', newID);
        var newRadioID = 'driveOptions' + (count + 1);
        cloned.find("input[name^='driveOptions']").each(function() {
            $(this).prop('name', newRadioID);
        });

        //Add after the correct div
        cloned.insertAfter('#driveRow' + count);

        //Increment counter
        count++;

        //Enable removal button
        if (count >= 2) {
            $('#btnRemoveDrive').removeClass('disabled');
            $('#btnRemoveDrive').prop('disabled', false);
        }

        //Disable adding more if count is equal to 4
        if (count == 4) {
            $('#btnAddDrive').addClass('disabled');
            $('#btnAddDrive').prop('disabled', true);
            return;
        }
    });

    $('#btnRemoveDrive').click(function() {
        //Remove the last dropdown
        $('div[id^=drive]:last').remove();

        //Enable and disable buttons as appropriate
        var count = $('div[id^=drive]').length;

        if (count == 1) {
            $('#btnRemoveDrive').addClass('disabled');
            $('#btnRemoveDrive').prop('disabled', true);
        }

        //Disable adding more if count is equal to 4
        if (count <= 3) {
            $('#btnAddDrive').removeClass('disabled');
            $('#btnAddDrive').prop('disabled', false);
            return;
        }
    });
});