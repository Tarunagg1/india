var searchText = '';

var baseUrl='';
if(!window.location.origin){
    baseUrl = window.location.protocol + '//' + window.location.host;
}else{
    baseUrl = window.location.origin;
}

$(document).ready(function(){
    $('#search').keypress(function(e) {
        if(e.which == 13) {
            searchText = $(this).val();
            searchTerm(searchText);
        }
        $('#searcErr').hide();
    });

    $( "#from" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: 'dd-mm-yy',
        maxDate: new Date(),
        onClose: function( selectedDate ) {
            $( "#to" ).datepicker( "option", "minDate", selectedDate );
            $("#from").blur();
        }
    });
    $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        dateFormat: 'dd-mm-yy',
        maxDate: new Date(),
        onClose: function( selectedDate ) {
            $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            $("#to").blur();
        }
    });

    $('#sort_criteria').on('change', function(){
        var criteria = $(this).val();
        searchText = $('#search').val().trim();
        var contentType = $('input[name="group1"]:checked').val();
        var dateFrom = $("#from").val();
        var dateTo = $("#to").val();

        searchText = searchText.replace(" ", "-");

        if(searchText != null && searchText != '' && searchText != undefined){
            if(dateFrom != '' || dateTo != ''){
                if(dateFrom != '' && dateTo != ''){
                    window.location.href = baseUrl + '/search-results/'+searchText+'/'+criteria+'/'+contentType+'/' + dateFrom + '/' + dateTo;
                }else if(dateFrom == '' && dateTo != ''){
                    window.location.href = baseUrl + '/search-results/'+searchText+'/'+criteria+'/'+contentType+'/null' + '/' + dateTo;
                }else if(dateTo == '' && dateFrom != ''){
                    window.location.href = baseUrl + '/search-results/'+searchText+'/'+criteria+'/'+contentType+'/' + dateFrom;
                }
            }else{
                window.location.href = baseUrl + '/search-results/'+searchText+'/'+criteria+'/'+contentType+'';
            }
        }else{
            $('#searcErr').show();
        }
    });

    $('input[name="group1"]').on('click', function(){
        var contentType = $(this).val();
        searchText = $('#search').val().trim();
        var criteria = $('#sort_criteria').val();
        var dateFrom = $("#from").val();
        var dateTo = $("#to").val();

        searchText = searchText.replace(" ", "-");

        if((searchText != null && searchText != '' && searchText != undefined) && (contentType != null && contentType != '' && contentType != undefined)){
            if(dateFrom != '' || dateTo != ''){
                if(dateFrom != '' && dateTo != ''){
                    window.location.href = baseUrl + '/search-results/'+searchText+'/'+criteria+'/'+contentType+'/' + dateFrom + '/' + dateTo;
                }else if(dateFrom == '' && dateTo != ''){
                    window.location.href = baseUrl + '/search-results/'+searchText+'/'+criteria+'/'+contentType+'/null' + '/' + dateTo;
                }else if(dateTo == '' && dateFrom != ''){
                    window.location.href = baseUrl + '/search-results/'+searchText+'/'+criteria+'/'+contentType+'/' + dateFrom;
                }
            }else{
                window.location.href = baseUrl + '/search-results/'+searchText+'/'+criteria+'/'+contentType+'';
            }
        }else{
            $('#searcErr').show();
        }
    });

    var supportsOrientationChange = "onorientationchange" in window,
    orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";


    if(orientationEvent == 'orientationchange'){
        window.addEventListener(orientationEvent, function() {
            //alert('orientation event');
            $("#from").datepicker("hide");
            $("#to").datepicker("hide");
        }, false);
    }
});

function searchTerm(term){
    if(term != null && term != '' && term != undefined){
        searchResult();
    }else{
        $('#searcErr').show();
    }
}

function searchResult(){
    var term = $('#search').val().trim();
    var sortCriteria = $('#sort_criteria').val();
    var contentType = $('input[name="group1"]:checked').val();
    var dateFrom = $("#from").val();
    var dateTo = $("#to").val();

    term = term.replace(" ", "-");

    if(term != null && term != '' && term != undefined){
        if(dateFrom != '' || dateTo != ''){
            if(dateFrom != '' && dateTo != ''){
                window.location.href = baseUrl + '/search-results/'+term+'/'+sortCriteria+'/'+contentType+'/' + dateFrom + '/' + dateTo;
            }else if(dateFrom == '' && dateTo != ''){
                window.location.href = baseUrl + '/search-results/'+term+'/'+sortCriteria+'/'+contentType+'/null' + '/' + dateTo;
            }else if(dateTo == '' && dateFrom != ''){
                window.location.href = baseUrl + '/search-results/'+term+'/'+sortCriteria+'/'+contentType+'/' + dateFrom;
            }
        }else{
            window.location.href = baseUrl + '/search-results/'+term+'/'+sortCriteria+'/'+contentType+'';
        }
    }else{
        $('#searcErr').show();
    }
}