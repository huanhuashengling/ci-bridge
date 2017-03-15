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
		$("#modal-title").html("编辑教师信息");
		$("#edit-teacher-info").html("编辑");

		var teacherName = $(this).closest("tr").eq(0).children(0).eq(1).text();
		var courseLeader = $(this).closest("tr").eq(0).children(0).eq(2).attr("coursesId");
		var classTeacher = $(this).closest("tr").eq(0).children(0).eq(3).attr("classesId");
		var teacherCourses = $(this).closest("tr").eq(0).children(0).eq(4).attr("teacherCoursesId");
		var values = teacherCourses.split(",");

		$("#teachers-id").val($(this).val());
		$("#teacher-name").val(teacherName);
		if (courseLeader) {
			$("input:radio[name='courseLeader']").filter('[value='+courseLeader+']').prop('checked', true);
		}
		$("#class-teacher").val(classTeacher);
		if (teacherCourses) {
			$("input:checkbox[name='teacherCourse']").filter('[value=' + values.join('], [value=') + ']').prop("checked", true);
		}
		$('#popup').modal('show');
	});

	$("#edit-teacher-info").click(function(e){
		var teacherCourse = [];
        $('input[name=teacherCourse]:checked').each(function(i){
          teacherCourse[i] = $(this).val();
        });
		var data = {teachersId : $("#teachers-id").val(),
					courseLeader : $('input[name=courseLeader]:checked').val(),
					classTeacher : $("#class-teacher").val(),
					teacherCourse : teacherCourse,
					teacherName : $("#teacher-name").val(),
					};
		var url = "/school/ajax-update-teacher-info";
		if ("添加" == $("#edit-teacher-info").html()) {
			url = "/school/ajax-add-teacher";
		}
		// console.log(data);
		$.ajax({
				type: 'POST',
				data: data,
				url: url,
				success: function(data) {
					if ("true" == data) {
						$('#popup').modal('hide');
						top.location.href = '/school/teachers-data-management';
					} else {
						alert("操作失败！");
					}
					
				}
			});
	});

	$('.add-teacher-btn').click(function(e) {
		$("#modal-title").html("添加教师用户");
		$("#teachers-id").val("");
		$("#teacher-name").val("");
		$("input:radio[name='courseLeader']").prop("checked", false);
		$("#class-teacher").val("");
		$("#edit-teacher-info").html("添加");
		$("input:checkbox[name='teacherCourse']").prop("checked", false);
		$('#popup').modal('show');
	});
});
