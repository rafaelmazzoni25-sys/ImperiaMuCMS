$(function(){
	
	$('.no_js_hide').show();
	
	var redirectStep = function( infoBox, url, baseurl ) {
		console.log(url);
		console.log('baseurl = ' + baseurl );
	
		$.ajax( url, {
			dataType: 'json',
			timeout: 30000,
			complete: function( jqXHR, textStatus )
			{				
				var response = $.parseJSON( jqXHR.responseText );

				console.log(response);
				
				infoBox.children('span').html( response[1] );
				if ( response[2] ) {
					infoBox.children('.loading').hide();
					infoBox.children('.progress').removeClass('hide');
					infoBox.children('.progress').show().find('.progress-bar').css({ width: ( response[2] + '%' ) });
					infoBox.children('.progress').show().find('.progress-bar').css({ width: ( response[2] + '%' ) });
				}
				
				var newurl = baseurl + '&mr=' + JSON.stringify( response[0] );
				
				if ( response[0] == '__done' ) {
					window.location = baseurl.replace('controller=install&continue=1','controller=done');	
				} else {
					redirectStep( infoBox, newurl, baseurl );
				}
			},
			error: function( jqXHR, textStatus )
			{
				if( jqXHR.responseText )
				{
					infoBox.children('span').html( jqXHR.responseText );
					return;
				}

				if ( jqXHR === 'timeout' )
				{
					var counter = ( getUrlParam('count') === false ) ? 0 : parseInt( getUrlParam('count') );
				
					if ( counter < 101 )
					{
						window.location = window.location.replace( /&count=([0-9]+?)(&|$)/, '' ) + '&count=' + ( counter + 1 );
						return;
					}
					
					if ( confirm( "The server encountered multiple instances where it has stopped responding.\nPress 'OK' to reload this page and re-run this installation step.") )
					{
						window.location = window.location.replace( /&count=([0-9]+?)(&|$)/, '' ) + '&count=' + ( counter + 1 );
						return;
					}
				}

				//window.location = url;
			}
		});
	};
	
	var getUrlParam = function( name )
	{
		if ( name = ( new RegExp( '[?&]'+encodeURIComponent( name ) + '=([^&]*)' ) ).exec( location.search ) )
		{
			return decodeURIComponent( name[1] );
		}
		
		return false;
  	};
	
	$('.redirect').each(function(){
		redirectStep( $(this).children('.no_js_hide'), $(this).attr('data-url') + '&mr=0', $(this).attr('data-url') );
	});
})