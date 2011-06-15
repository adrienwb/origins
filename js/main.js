var selectedElements=new Array();

$(document).ready(function () {
    $('#gallery').submit(function () {

		for(var i=0; i<selectedElements.length; i++) {
			var value = selectedElements[i];
			if(value!=undefined)addElement(i);
		}
		return false;
    });

    $(".element").draggable({
        cursor: "move",
        opacity: 0.7,
        stack: "#playground div" 
    }).droppable({
        drop: function (event, ui) {
           combine(ui,$(this));
           }
    });

});

function unselectAllElements(){
	for(var i=0; i<selectedElements.length; i++) {
		var value = selectedElements[i];
		if(value!=undefined){
			$('li[element='+i+']').removeClass('selected');
		}
	}
	selectedElements=new Array();
	return false;
}

function selectElement(obj){
	if($(obj.parentNode).hasClass('selected')){
		$(obj.parentNode).removeClass('selected');
		selectedElements[$(obj.parentNode).attr('element')]=undefined;
	}else{
		$(obj.parentNode).addClass('selected');
		selectedElements[$(obj.parentNode).attr('element')]=1;
	}
}

function combine(ui, $this) {
	var dragged = ui.draggable.attr('id');
	var dropped = $this.attr('id');

	console.log(ui.position.left,ui.position.top);
	$.post("ajax.php", {
		action: 'combine',
		source: dragged,
		target: dropped
	}, function (data) {

		if (data != null) {
			
			$('.message').fadeIn('slow', function () {
				// Animation complete.
				$('#message-content').html('good job, ' + data.name + ' created');

			});
			$('#playground').append('<div class="element" id="' + data.id + '"><img src="img/elements/' + data.id + '.png" /></div>');


			$("#"+data.id).draggable({
				cursor: "move",
				opacity: 0.7,
				stack: "#playground div" 
			}).droppable({
				drop: function (event, ui) {
				   combine(ui,$(this));
				   }
			});

			$('#'+dragged).remove();
			$('#'+dropped).remove();
			

		} else {
			$('#message-content').html('you suck');
		}
	}, "json").success(function () { /*console.log("second success");*/
	}).error(function () { /*console.log("error");*/
	}).complete(function () { /*console.log("complete");*/
	});
}

function addElement(id){
	$('#playground').append('<div class="element" id="' + id + '"><img src="img/elements/' + id + '.png" /></div>');
	$(".element").draggable({
		cursor: "move",
		opacity: 0.7,
		stack: "#playground div" 
	}).droppable({
		drop: function (event, ui) {
		   combine(ui,$(this));
		   }
	});
	$(".element").css('left','40px').css('top','40px');

}