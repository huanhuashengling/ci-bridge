$(document).ready(function() {
	
	$("#class-select").change(function(e){
		var data = {classesId : $(this).val()};
		$.ajax({
				type: 'POST',
				data: data,
				url: "/school/ajax-get-students-list",
				success: function(data) {
					// console.log(data);
					$("#students-list").html(data);
				}
			});
	});



});
