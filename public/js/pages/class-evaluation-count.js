$(document).ready(function() {
	$(".class-btn").on('click', function(e) {
		e.preventDefault();
		// alert($(this).children().attr('id'));
		var coursesId = $("div[name='course-btn-group'] .active").children().attr('id');
		var classesId = $(this).children().attr('id');
		if (!classesId) {
			alert("您未选择班级！");
		} else {
			var data = {classesId : classesId, coursesId : coursesId};
	    	$.ajax({
				type: 'POST',
				data: data,
				url: "/school/ajax-get-class-evaluation-count",
				success: function(data) {
					$("#class-evaluation-list").html(data);
				}
			});
		}
	});

	$(".course-btn").on('click', function(e) {
		e.preventDefault();
		var classesId = $("div[name='class-btn-group'] .active").children().attr('id');
		var coursesId = $(this).children().attr('id');
		if (!classesId) {
			alert("您未选择班级！");
		} else {
			var data = {classesId : classesId, coursesId : coursesId};
	    	$.ajax({
				type: 'POST',
				data: data,
				url: "/school/ajax-get-class-evaluation-count",
				success: function(data) {
					$("#class-evaluation-list").html(data);
				}
			});
		}
	});
});
