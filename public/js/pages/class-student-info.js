$(document).ready(function() {
	$(".delete-btn").click(function(e){
		if (confirm("确认删除这个学生信息吗？")) {
			var studentsId = $(this).val();
	    	deleteEvaluteItem(studentsId, $(this).closest("tr"));
	  	}
	});

	$("#add-btn").click(function(e){
		$('#addPop').modal('show');
	});

	$("#pop-submit-btn").click(function(e) {
		var studentName = $("input[name='studentName']").val();
		if ("" == studentName) {
			alert("学生姓名不能为空！");
		}
		var studentGender = $("input[name='studentGender']").val();
		if ("" == studentGender) {
			alert("学生性别不能为空！");return;
		} else if ("男" != studentGender && "女" != studentGender) {
			alert("性别只能填男/女！");
			return;
		}
		var classesId = $("input[name='classesId']").val();
		var data = {studentName:studentName,
					classesId:classesId,
					studentGender:("男" == studentGender)?1:0}
		console.log(data);
		$.ajax({
				type: 'POST',
				data: data,
				url: "/teacher/ajax-add-student",
				success: function(data) {
					top.location.href = '/teacher/class-student-info';
				}
			});
	});

	function deleteEvaluteItem(studentsId, listItem)
	{
		var data = {studentsId:studentsId}
		$.ajax({
				type: 'POST',
				data: data,
				url: "/teacher/ajax-delete-student",
				success: function(data) {
					listItem.addClass('hidden');
				}
			});
	}
});
