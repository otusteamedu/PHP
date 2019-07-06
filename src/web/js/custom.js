$(function() {

    $(document).on('click', '#addEventButton', function() {
    
        var myUrl = "/site/addevent";
        var myData = {};
        
        $('form.addEvent > input[type=text], form.addEvent > input[type=number]').each( function (indx, value) {
    	    myData[ $(this).attr("name") ] = $(this).val();
        });
        
        load(myUrl, myData, "GET", "json", function(response) {
    	    var result = response['result'];
    	    if (result != false) {
    		$('#eventsList').append('<div>' + result + '</div>');
    	    } else {
    		alert('Введите правильные значения!')
    	    }
    	    $('form.addEvent > input[name="priority"]').val('');
    	    $('form.addEvent > input[name="param1"]').val('');
    	    $('form.addEvent > input[name="param2"]').val('');
        });
        
	return false;
    });

    $(document).on('click', '#delEventsButton', function() {
    
        var myUrl = "/site/delevents";
        var myData = {};
        
        load(myUrl, myData, "GET", "json", function(response) {
    	    $('#eventsList').html('');
    	    $('#eventsResults').html('');
    	    $('#eventsSearch').hide();
        });
        
	return false;
    });

    $(document).on('click', '#findEventsButton', function() {
    
        var myUrl = "/site/findevents";
        var myData = {};

        $('form.findEvents > input[type=text]').each( function (indx, value) {
    	    myData[ $(this).attr("name") ] = $(this).val();
        });
        
        load(myUrl, myData, "GET", "json", function(response) {
    	    $('#eventsResults').html('');

    	    console.log(response['result']);
    	    if (response['result'].length > 0) {
    	        $.each(response['result'], function(indx, val) {
    	    	    $('#eventsResults').append('<div>' + val + '</div>');
    		});
    		$('#eventsSearch').show();
    	    } else {
    		$('#eventsSearch').hide();
    	    }
    	    
    	    
        });
        
	return false;
    });
    
    function load(myUrl, myData, myRequest, myType, callback) {
	var myDate = new Date();

	if (typeof myUrl === "undefined") myUrl = "";
	if (typeof myData === "undefined") myData = {};
	if (typeof myType === "undefined") myType = "json";
	if (typeof myRequest === "undefined") myRequest = "POST";
	$.ajax({
	    type       : myRequest,
	    url        : myUrl,
	    crossDomain: true,
	    cache      : false,
	    data       : myData,
	    dataType   : myType,
	    success    : function(response) { callback(response); }
	});
    }
});

