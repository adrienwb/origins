var selectedElements=new Array();

$(document).ready(function () {
    $('#gallery').submit(function () {

		for(var i=0; i<selectedElements.length; i++) {
			var value = selectedElements[i];
			if(value!=undefined)addElement(i);
		}
		return false;
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

	$.post("ajax.php", {
		action: 'combine',
		source: dragged,
		target: dropped
	}, function (data) {

		if (data != null) {
			
			$('.message').fadeIn('slow', function () {
				// Animation complete.
				$('#message-content').html('good job, ' + data.name + ' created');
				$("#elements").append('<li element="'+data.id+'"><a onclick="selectElement(this); return false;" title="'+data.name+'" href="#">'+
						'<span style="background-image: url(&quot;img/elements/'+data.id+'.png&quot;);" class="square"><span></span></span><strong'+data.name+'</strong></a></li>');
			});
			addElement(data.id,ui.position.left,ui.position.top);

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

function addElement(id,left,top){
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