$(document).ready(function() {
	$('.class-btn').click(function(e) {
		var data = {classesId : $(this).attr('value')};
		$.ajax({
				type: 'POST',
				data: data,
				url: "../teacher/classes-selection",
				success: function(data) {
					location.href = '../teacher/classroom-evaluation';
				}
			});
	});
});
