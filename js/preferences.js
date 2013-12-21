$(function() {  

    $("#save").click(function() {
        savePreferencesviaAjax();
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
            displayNewRow();
            clearValuesEntered();
        }).fail(function(msg){
            alert('Monkey business is out of business! Please resubmit trip idea.');
        }); // end ajax setup
    } 

    function displayNewRow() {
        alert('max price entered:'+$('#max_price').val());
    }

    function clearValuesEntered() {
        $('#airport').val("");
        $('#month').val("");
        $('#year').val("");
        $('#region').val("");
        $('#max_price').val("");
    }

    $("#delete").click(function() {
        deletePreferencesviaAjax();
    });

    function deletePreferencesviaAjax(){
        $.ajax({
            type: 'POST',
            url: '/users/p_preferences_delete',
            data: {
                preference_id: $('#preference_id').val()
                },
            cache: false
        }).done(function(msg){
            deleteRow();
        }).fail(function(msg){
            alert('Monkey business is out of business! Please resubmit trip idea.');
        }); // end ajax setup
    }

    function deleteRow() {
        alert('preference_id:'+$('#preference_id').val());
        $('#preference_id').parent().parent().remove();
    }

}); 