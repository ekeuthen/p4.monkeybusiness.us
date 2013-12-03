//using Airport Code webservice: http://airportcode.riobard.com/
//code extended from http://jsfiddle.net/BQxw4/40/

function buildQuery(term) {
    return "select * from json where url = 'http://airportcode.riobard.com/search?fmt=JSON&q=" + encodeURI(term) + "'";
}

function makeRequest(request, response) {
    $.ajax({
        url: 'http://query.yahooapis.com/v1/public/yql',
        data: {
            q: buildQuery(request.term),
            format: "json"
        },
        dataType: "jsonp",
        success: function(data) {
            var airports = [];
            if (data && data.query && data.query.results && data.query.results.json && data.query.results.json.json) {
                airports = data.query.results.json.json;
            }

            response($.map(airports, function(item) {
                return {
                    label: item.code + (item.name ? ", " + item.location : ""),
                    value: item.code
                };
            }));
        },
        error: function () {
            response([]);
        }
    });
}

$(document).ready(function() {
    $("#airport").autocomplete({
        source: makeRequest,
        minLength: 2
    });
});