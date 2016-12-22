$(document).ready(function() {
	$('#sib-sidebar').css('margin-left', '-' + $('#sib-sidebar').outerWidth() + 'px');
	$('#sib-sidebar-toggle').click(function(e) {
		if($('#sib-sidebar').css("margin-left") == '0px'){
			$('#sib-sidebar').css('margin-left', '-' + $('#sib-sidebar').outerWidth() + 'px');
			$('#sib-sidebar-toggle').css('transform', 'rotate(180deg)');
			$('#sib-sidebar-toggle').css('background-color', '#9e9e9e');
			$('.gmnoprint .gm-style-mtc').first().css('margin-left', '10px');
		}
		else{
			console.log($('#sib-sidebar').width());
			$('#sib-sidebar').css('margin-left', '0');
			$('#sib-sidebar-toggle').css('transform', 'inherit');
			$('#sib-sidebar-toggle').css('background-color', '#616161');
			$('.gmnoprint .gm-style-mtc').first().css('margin-left', ($('#sib-sidebar').outerWidth() + 10) + 'px');
		}
	});
});