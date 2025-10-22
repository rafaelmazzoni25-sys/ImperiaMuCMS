$(document).ready(function()
{WarcryQueue('onload').goNext();$(document).find('select').each(function(index,element)
{if(typeof $(element).attr('styled')!='undefined')
{if($(element).attr('id')=='character-select')
{$(element).SelectTransform({scrollConfig:{scrollBy:4,}});}
else
{$(element).SelectTransform();}}});});$(function()
{if($('.vertical_center').length>0)
{$('.vertical_center').each(function()
{var parentHeight=$(this).parent().height();var height=$(this).outerHeight();$(this).css('position','relative');$(this).parent().css('height',(height+15)+'px');$(this).css({top:(parentHeight/2)+'px',marginTop:'-'+(height/2)+'px'});});}});function CenterSWFMovie(id)
{$this=$('#'+id);if($this.length>0)
{if(navigator.appName=='Microsoft Internet Explorer')
{var $window=$(window);var $width=$window.width();var $height=$window.height();setInterval(function()
{if(($width!=$window.width())||($height!=$window.height()))
{$width=$window.width();$height=$window.height();if($this.css('position')!='absolute')
{$this.css('position','absolute');}
var windowWidth=$(window).width();var width=$this.width();if(windowWidth<=1024)
{return;}
$this.css({left:(windowWidth/2)+'px',marginLeft:'-'+(width/2)+'px'});}},100);}
else
{$(window).resize(function()
{console.log('Resize!');if($this.css('position')!='absolute')
{$this.css('position','absolute');}
var windowWidth=$(window).width();var width=$this.width();if(windowWidth<=1024)
{return;}
$this.css({left:(windowWidth/2)+'px',marginLeft:'-'+(width/2)+'px'});});}}}
if(navigator.userAgent.toLowerCase().indexOf("chrome")>=0)
{$(window).load(function(){$('input:-webkit-autofill').each(function(){var text=$(this).val();var name=$(this).attr('name');$(this).after(this.outerHTML).remove();$('input[name='+name+']').val(text);});setTimeout(function()
{$('input:-webkit-autofill').each(function(){var text=$(this).val();var name=$(this).attr('name');$(this).after(this.outerHTML).remove();$('input[name='+name+']').val(text);});},100);});}
function setupLabel()
{if($('.label_check input').length)
{$('.label_check').each(function()
{$(this).removeClass('c_on');});$('.label_check input:checked').each(function()
{$(this).parent('label').addClass('c_on');});};if($('.label_radio input').length)
{$('.label_radio').each(function()
{$(this).removeClass('r_on');});$('.label_radio input:checked').each(function()
{$(this).parent('label').addClass('r_on');});};};$(document).ready(function()
{$('body').addClass('has-js');$('.label_check, .label_radio').click(function()
{setupLabel();});setupLabel();});