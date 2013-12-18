$(function() {  

    $("#save").click(function() {
       // alert("save button clicked!");
       console.log('invoking ajax call');
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
            alert('monkey business is out of business?');
        }); // end ajax setup
    } 


function displayNewRow() {
    alert('max price entered:'+$('#max_price').val());
}

function clearValuesEntered() {
    alert('max price entered:'+$('#max_price').val());
}
}); 