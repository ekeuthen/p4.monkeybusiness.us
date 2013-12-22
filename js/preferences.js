$(function() {  

    $("#save").click(function() {
        var valid = true,
        errorMessage = "";

        if ($('#airport').val() == '') {
           errorMessage  = "Please select a home airport. \n";
           valid = false;
        }

        if ($('#airport').val().length > 3) {
           errorMessage  = "Please select a three character airport code. \n";
           valid = false;
        }

        if(!$.isNumeric($('#max_price').val())) {
            errorMessage  = "Please enter a numeric maxium price. \n";
            valid = false;
        }

        if( !valid && errorMessage.length > 0){
           alert(errorMessage);
        } else {
            savePreferencesviaAjax();
        }
    });

    function savePreferencesviaAjax(){
        $.ajax({
            type: 'POST',
            url: '/users/save_preferences_via_ajax',
            data: {
                airport: $('#airport').val(),
                month: $('#month').val(),
                year: $('#year').val(),
                region: $('#region').val(),
                max_price: $('#max_price').val(),
                },
            cache: false
        }).done(function(msg){
            displayNewRow(msg);
            clearValuesEntered();
        }).fail(function(msg){
            alert('Monkey business is out of business! Please resubmit trip idea.');
        }); // end ajax setup
    } 

    function displayNewRow(msg) {
        var result = $.parseJSON(msg);
        var tableHtml = 
            "<tr>"+
                "<td>"+
                    "<button class='delete' id='"+result.preference_id+"'>Delete</button>"+
                "</td>"+
                "<td>"+result.created+"</td>"+
                "<td>"+result.airport+"</td>"+
                "<td>"+result.year+"</td>"+
                "<td>"+result.region+"</td>"+
                "<td>"+result.max_price+"</td>"+
            "</tr>";
        // each delete button gets its own anonymous click listener
        // as jQuery does not detect newly created elements on the fly 
        // without the live() method
        var test = $(tableHtml).find('button').click(function () {
                // delete row using ajax
                deletePreferencesviaAjax(result.preference_id);
            }).end();
        $("#preferenceList tr:last").before(test);
    }

    function clearValuesEntered() {
        $('#airport').val("");
        $('#month').val("");
        $('#year').val("");
        $('#region').val("");
        $('#max_price').val("");
    }

    $(".delete").on("click", function() {
        var preference = this.id;
        deletePreferencesviaAjax(preference);
    });

    function deletePreferencesviaAjax(preference){
        $.ajax({
            type: 'POST',
            url: '/users/p_preferences_delete',
            data: {
                preference_id: preference
                },
            cache: false
        }).done(function(msg){
            deleteRow(msg);
        }).fail(function(msg){
            alert('Monkey business is out of business! Please resubmit trip idea.');
        }); // end ajax setup
    }

    function deleteRow(msg) {
        $("#"+msg).parent().parent().remove();
    }

}); 