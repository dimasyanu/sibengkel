$(document).ready(function() {
	$('#sib-sidebar-toggle').click(function(e) {
		if($('#sib-sidebar').css("margin-left") == '0px'){
			$('#sib-sidebar').css('margin-left', '-' + $('#sib-sidebar').outerWidth() + 'px');
			$('#sib-sidebar-toggle').css('transform', 'rotate(180deg)');
			$('#sib-sidebar-toggle').css('background-color', '#9e9e9e');
		}
		else{
			$('#sib-sidebar').css('margin-left', '0');
			$('#sib-sidebar-toggle').css('transform', 'inherit');
			$('#sib-sidebar-toggle').css('background-color', '#616161');
		}
	});
});