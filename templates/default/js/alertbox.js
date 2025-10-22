(function($)
{var $AlertBox={};var methods={getCaller:function()
{return(typeof $(this)!='undefined')?$AlertBox.CalledBy:null;},open:function(html,buttons)
{if(typeof $(this)!='undefined')
{$AlertBox.CalledBy=$(this);}
else
{$AlertBox.CalledBy=null;}
$('body').append('<div id="Alert-box_container" align="center"><div class="alert-box-holder">'+html+'</div></div>');if(typeof buttons=='object')
{$('.alert-box-holder').append('<div class="alert-box-buttons"></div>');for(var key in buttons)
{var button=buttons[key];var newButton=$('<a href="#">'+button.text+'</a>');if(typeof button.onclick=='string')
{if(button.onclick=='close')
$(newButton).click(function(){$.fn.ImperiaAlertBox('close');return false;});}
else if(typeof button.onclick=='function')
{$(newButton).click(button.onclick);}
$('.alert-box-buttons').append(newButton);}}
$('#Alert-box_container').stop().animate({opacity:1},'fast');$AlertBox.closeEvent=true;$('#Alert-box_container > .alert-box-holder').on('mouseenter',function()
{$AlertBox.closeEvent=false;});$('#Alert-box_container > .alert-box-holder').on('mouseleave',function()
{$AlertBox.closeEvent=true;});$('#Alert-box_container').on('click',function()
{if($AlertBox.closeEvent)
{$.fn.ImperiaAlertBox('close');}});$(document).keyup(function(e)
{if(e.keyCode==27)
{if($('#Alert-box_container').length>0)
{if($('#Alert-box_container').is(':visible'))
{$.fn.ImperiaAlertBox('close');}}}});},close:function()
{$('#Alert-box_container').detach();},}
$.fn.ImperiaAlertBox=function(method)
{if(methods[method])
{return methods[method].apply(this,Array.prototype.slice.call(arguments,1));}
else
{$.error('Method '+method+' does not exist on jQuery.ImperiaAlertBox');}};})(jQuery);