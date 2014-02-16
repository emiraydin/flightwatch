$(document).ready(function() {

    $("#first").submit(function(event){
        // prevent default posting of form
        event.preventDefault();

        $("#first").hide();
        var new_form = '<form id="second"><input type="text" class="form-control form-airline" placeholder="Airline Code" required="" autofocus="" id="airline"><input type="text" class="form-control form-flightno" placeholder="Flight Number" required="" id="flight_no"><input type="submit" class="btn btn-lg btn-default" value="Send" /></form>';
        $("#formscenter").append(new_form);

    });
    // variable to hold request
    var request;
    // bind to the submit event of our form
    $("#second").submit(function(event){
        // abort any pending request
        if (request) {
            request.abort();
        }
        // setup some local variables
        var $form = $(this);
        // let's select and cache all the fields
        var $inputs = $form.find("input");
        // serialize the data in the form
        var serializedData = $form.serialize();
        serializedData.access_key = $("#access_key").val();
        serializedData.feature = 'add_flight_to_access_key';
        // let's disable the inputs for the duration of the ajax request
        $inputs.prop("disabled", true);

        // fire off the request to /form.php
        request = $.ajax({
            url: "http://flightwatch.org/main.php",
            type: "post",
            data: serializedData
        });

        // callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            // log a message to the console
            if (response.success == 'yes')
                console.log("Confirmed! Check your Pebble for flight updates!");
            else
                console.log("Please check your access key and enter again.");
        });

        // callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.error(
                "The following error occured: "+
                textStatus, errorThrown
            );
        });

        // callback handler that will be called regardless
        // if the request failed or succeeded
        request.always(function () {
            // reenable the inputs
            $inputs.prop("disabled", false);
        });

        // prevent default posting of form
        event.preventDefault();
    });

});

