/*
funkcija koja izbacuje loading prozor pri kliku na class="restartDugme"
*/
var ip,id;

$(document).ready(function(){
	$(".red").each(function(i) {
		refreshGT($(this).attr("rel"),$(this).attr("id"));
	});
	
	
	$(".restartDugme").click(function(event){
		$("#mrak").fadeIn("slow");
		$("#load_popup").center().show();
	});
});

function refreshGT(ip,id) {
	$.ajax({
		type: "POST",
		url: "process.php",
		data: {
			'task': 'gtstatus',
			'ip': ip
		},
		dataType: "json",
		success: function(data){
			$("#"+id+" td:nth-child(3)").text(data.players);
			$("#"+id+" td:nth-child(4)").text(data.status);
		},
	});
}
/*
funkcija za centriranje div-a
source: http://plugins.jquery.com/project/autocenter
author: molokoloco

koriscenje:
$('#element').center();
$(window).bind('resize', function() {
    $('#element').center();
});
*/
(function($){
     $.fn.extend({
          center: function (options) {
               var options =  $.extend({ // Default values
                    inside:window, // element, center into window
                    transition: 0, // millisecond, transition time
                    minX:0, // pixel, minimum left element value
                    minY:0, // pixel, minimum top element value
                    vertical:true, // booleen, center vertical
                    withScrolling:true, // booleen, take care of element inside scrollTop when minX < 0 and window is small or when window is big
                    horizontal:true // booleen, center horizontal
               }, options);
               return this.each(function() {
                    var props = {position:'absolute'};
                    if (options.vertical) {
                         var top = ($(options.inside).height() - $(this).outerHeight()) / 2;
                         if (options.withScrolling) top += $(options.inside).scrollTop() || 0;
                         top = (top > options.minY ? top : options.minY);
                         $.extend(props, {top: top+'px'});
                    }
                    if (options.horizontal) {
                          var left = ($(options.inside).width() - $(this).outerWidth()) / 2;
                          if (options.withScrolling) left += $(options.inside).scrollLeft() || 0;
                          left = (left > options.minX ? left : options.minX);
                          $.extend(props, {left: left+'px'});
                    }
                    if (options.transition > 0) $(this).animate(props, options.transition);
                    else $(this).css(props);
                    return $(this);
               });
          }
     });
})(jQuery);