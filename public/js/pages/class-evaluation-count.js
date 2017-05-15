$(document).ready(function() {
	$('#check-count').on('click', function(e) {
		e.preventDefault();
		var coursesId = $("div[name='course-btn-group'] .active").children().attr('id');
		var classesId = $("div[name='class-btn-group'] .active").children().attr('id');
		var data = {classesId : classesId, coursesId : coursesId};
		// console.log(data);
    	$.ajax({
			type: 'POST',
			data: data,
			url: "/school/ajax-get-class-evaluation-count",
			success: function(data) {
				$("#class-evaluation-list").html(data);
			}
		});
	});
});
