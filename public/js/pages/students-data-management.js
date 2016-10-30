$(document).ready(function() {
	$("#class-select").change(function(e){
		var data = {classesId : $(this).val(), showInactive : $("#show-inactive").is(':checked')};
		$.ajax({
				type: 'POST',
				data: data,
				url: "/school/ajax-get-students-list",
				success: function(data) {
					$("#students-list").html(data);
				}
			});
	});
});
