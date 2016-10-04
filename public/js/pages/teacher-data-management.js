$(document).ready(function() {
	$('.reset-btn').click(function(e) {
		if (confirm("确认重置这位老师的密码为123456吗？")) {
			var teachersId = $(this).val();
	    	resetTeacherPassword(teachersId);
	  	}
	});

	function resetTeacherPassword(teachersId)
	{
		var data = {teachersId : teachersId};
		$.ajax({
				type: 'POST',
				data: data,
				url: "/school/ajax-reset-teacher-password",
				success: function(data) {
					if ("true" == data) {
						alert("重置密码成功！")
					} else {
						alert("重置密码失败！")
					}
				}
			});	
	}

	$('.edit-btn').click(function(e) {
		var teacherName = $(this).closest("tr").eq(0).children(0).eq(1).text();
		var courseLeader = $(this).closest("tr").eq(0).children(0).eq(2).text();
		var classTeacher = $(this).closest("tr").eq(0).children(0).eq(3).text();
		// alert($(this).val());
		$("#teachers-id").val($(this).val());
		$("#teacher-name").val(teacherName);
		$("#course-leader").val(courseLeader);
		$("#class-teacher").val(classTeacher);
		$('#popup').modal('show');
	});

	$("#edit-teacher-info").click(function(e){
		var data = {teachersId : $("#teachers-id").val(),
					courseLeader : $("#course-leader").val(),
					classTeacher : $("#class-teacher").val(),
					};
		$.ajax({
				type: 'POST',
				data: data,
				url: "/school/ajax-update-teacher-info",
				success: function(data) {
					if ("true" == data) {
						$('#popup').modal('hide');
						top.location.href = '/school/teachers-data-management';
					} else {
						alert("教师信息修改失败！");
					}
					
				}
			});
	});
});
