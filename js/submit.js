$(document).ready(function() {

    $("#first").submit(function(event){
        console.log('first form starts');
        // prevent default posting of form
        event.preventDefault();

        $("#first").hide();
        var new_form = '<input type="text" class="form-control form-airline" placeholder="Airline Code" required="" autofocus="" id="airline"><input type="text" class="form-control form-flightno" placeholder="Flight Number" required="" id="flight_no"><input type="submit" class="btn btn-lg btn-default" value="Finish" />';
        $("#second").append(new_form);
        $("#second").show();
        console.log('first form ends');

    });
    // variable to hold request
    var request;
    // bind to the submit event of our form
    $("#second").submit(function(event){
        // prevent default posting of form
        event.preventDefault();
        console.log('second form starts');
        // abort any pending request
        if (request) {
            request.abort();
        }
        // setup some local variables
        var $form = $(this);
        // let's select and cache all the fields
        // var $inputs = $form.find("input");
        // serialize the data in the form
        var serializedData = [];
        serializedData.airline = $("#airline").val();
        serializedData.flight_no = $("#flight_no").val();
        serializedData.access_key = $("#access_key").val();
        serializedData.feature = 'add_flight_to_access_key';
        console.log('data: ' + serializedData);
        // let's disable the inputs for the duration of the ajax request
        // $inputs.prop("disabled", true);

        // fire off the request to /form.php
        request = $.ajax({
            url: "/main.php",
            type: "get",
            data: serializedData
        });

        // callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            console.log(response);
            console.log(textStatus);
            console.log(jqXHR);
            // log a message to the console
            if (textStatus.success == 'yes') {
                console.log("Confirmed! Check your Pebble for flight updates!");
                $('#second').hide();
                $("#formscenter").append('<p>Confirmed! Check your Pebble for flight updates!</p>');
            }
            else {
                console.log("Please check your access key and enter again.");
                $('#second').hide();
                $("#formscenter").append('<p>Please check your access key and <a href="http://flightwatch.org">enter again.</a></p>');

            }
        });

        // callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // log the error to the console
            console.error(
                "The following error occured: "+
                textStatus, errorThrown
            );
        });

        console.log('second form ends');

        
    });

});

