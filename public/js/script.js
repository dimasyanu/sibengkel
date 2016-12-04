$(document).ready(function() {
	$('#sib-sidebar-toggle').click(function(e) {
		if($('#sib-sidebar').css("margin-left") == '0px'){
			$('#sib-sidebar').css('margin-left', '-' + $('#sib-sidebar').outerWidth() + 'px');
		}
		else{
			$('#sib-sidebar').css('margin-left', '0');
		}
	});
});