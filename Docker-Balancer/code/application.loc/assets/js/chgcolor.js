jQuery(function() {

	jQuery('#startRotate').css({'cursor':'pointer', 'color':'grey'});

	jQuery('#startRotate').hover(function(){
		if ($('.start_rotate').css('animation-name') == 'none') 
			jQuery('#startRotate').css('color', 'black');
		else 
			jQuery('#startRotate').css('color', '#500000');
	}, function() { 
		if ($('.start_rotate').css('animation-name') == 'none')
			jQuery('#startRotate').css('color', 'grey');
		else
			jQuery('#startRotate').css('color', 'maroon');
	})
	
	jQuery('#startRotate').on('click', function(){

		if ($('.start_rotate').css('animation-name') == 'none') {
			jQuery('.start_rotate').css('animation', 'target 1.8s infinite linear');
			jQuery('#startRotate').css('color', 'maroon');
		} else {
			jQuery('.start_rotate').css('animation', 'none')
			jQuery('#startRotate').css('color', 'grey');
		};
	});

	jQuery('#randomChange').submit(function(){
		
        var $url= '/vladimir/xhrChangeColor';
        var $data=jQuery("form").serialize();
      
        //console.log($data);
        //console.log($url);
        jQuery.post($url, $data, function($rdata){
        	
        jQuery('#square').css('backgroundColor', $rdata["color"]);
        }, 'json');
        return false;
    });
	

	jQuery.get('/vladimir/xhrGetColor', function (color) {
		jQuery('#square').css('background-color', color);
	}, 'json' )

	jQuery('.cc_red').on('click', function(){
		var $color = 'red';
		var $url= '/vladimir/xhrChangeColor';
		$.ajax({
	        url: $url,
	        type: 'POST',
	        data: {
	            color: $color
	        },
	        dataType: 'html',
	        success: function() {
	        	
		        var Element = document.getElementById('square');
				Element.style.backgroundColor = $color;
				return false;
	        }
		});
	})

	jQuery('.cc_blue').on('click', function(){
		var $color = 'blue';
		var $url= '/vladimir/xhrChangeColor';
		$.ajax({
	        url: $url,
	        type: 'POST',
	        data: {
	            color: $color
	        },
	        dataType: 'html',
	        success: function() {
	        	
		        var Element = document.getElementById('square');
				Element.style.backgroundColor = $color;
				return false;
	        }
		});
	})

	jQuery('.cc_green').on('click', function(){
		var $color = 'green';
		var $url= '/vladimir/xhrChangeColor';
		$.ajax({
	        url: $url,
	        type: 'POST',
	        data: {
	            color: $color
	        },
	        dataType: 'html',
	        success: function() {
	        	
		        var Element = document.getElementById('square');
				Element.style.backgroundColor = $color;
				return false;
	        }
		});
	});

	jQuery('#useSession').on('click', function(){
		let $url1= '/vladimir/xhrSetSquareUseSession';
		let $url2= '/vladimir/xhrGetColor';
		// сначала устанавливаем признак использования сессии
		$.ajax({
			url: $url1,
			type: 'POST',
			data: {
				'useSession': $(this).is(':checked')
			},
			dataType: 'html',
			success: function($useSession) {
				// затем запрашиваем цвет квадрата
				$.ajax({
					url: $url2,
					type: 'POST',
					data: {
						'useSession': $useSession
					},
					dataType: 'html',
					success: function(color) {
						let Element = document.getElementById('square');
						Element.style.backgroundColor = $.parseJSON(color);
						return false;
					}
				});
			}
		});
	});

});

function ChangeColor(IdElement, Color) {

		var Element = document.getElementById(IdElement);
		Element.style.backgroundColor = Color;
		return false;

	}