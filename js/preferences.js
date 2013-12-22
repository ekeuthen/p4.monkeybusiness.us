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
            displayNewRow(msg);
            clearValuesEntered();
        }).fail(function(msg){
            alert('Monkey business is out of business! Please resubmit trip idea.');
        }); // end ajax setup
    } 

    function displayNewRow(msg) {
        var result = $.parseJSON(msg);
        $('#preferenceList').append(
            "<tr>"+
                "<td>"+
                    "<input type='submit' value='Delete' class='delete'>"+
                "</td>"+
                "<td>"+result.created+"</td>"+
                "<td>"+result.airport+"</td>"+
                "<td>"+result.year+"</td>"+
                "<td>"+result.region+"</td>"+
                "<td>"+result.max_price+"</td>"+
            "</tr>");
    }

    function clearValuesEntered() {
        $('#airport').val("");
        $('#month').val("");
        $('#year').val("");
        $('#region').val("");
        $('#max_price').val("");
    }

    $(".delete").click(function() {
        var preference = this.id;
        deletePreferencesviaAjax(preference);
    });

    function deletePreferencesviaAjax(preference){
        $.ajax({
            type: 'POST',
            url: '/users/p_preferences_delete',
            data: {
                //preference_id: $('#preference_id').val()
                preference_id: preference
                },
            cache: false
        }).done(function(msg){
            deleteRow();
        }).fail(function(msg){
            alert('Monkey business is out of business! Please resubmit trip idea.');
        }); // end ajax setup
    }

    function deleteRow() {
        $('#preference_id').parent().parent().remove();
    }

}); 