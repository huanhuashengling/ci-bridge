$(document).ready(function() {
	$(document)
		.on('click', '.delete-btn', function(e){
			if (confirm("确认删除这个学生，同时删除相关所有记录吗？")) {
				var studentsId = $(this).val();
		    	deleteStudent(studentsId, $(this).closest("tr"));
		  	}
		})
		.on('click', '#add-btn', function() {
			$('#addPop').modal('show');
		})
		.on('click', '#pop-submit-btn', function(){
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
			// console.log(data);
			$.ajax({
					type: 'POST',
					data: data,
					url: "/teacher/ajax-add-student",
					success: function(data) {
						location.reload();
						// top.location.href = '/teacher/class-student-info';
					}
				});
		})
		.on('click' ,'.active-btn', function(e){
			var action = "deactivate";
			if ("激活" == $(this).text()) {
				action = "activate";
			}
			var data = {studentsId : $(this).val(), action : action};
			var item = $(this);
			$.ajax({
				type: 'POST',
				data: data,
				url: "/teacher/ajax-active-student",
				success: function(data) {
					if (data) {
						if ("activate" == action) {
							item.removeClass('btn-success');
							item.addClass('btn-danger');
							item.html('冻结');
						} else {
							item.removeClass('btn-danger');
							item.addClass('btn-success');
							item.html('激活');
						}
					} else {
						alert("操作失败！");
					}
				}
			});
		});

	function deleteStudent(studentsId, listItem)
	{
		var data = {studentsId:studentsId};
		$.ajax({
				type: 'POST',
				data: data,
				url: "/teacher/ajax-delete-student",
				success: function(data) {
					console.log(data);
					if (data) {
						listItem.addClass('hidden');
					} else {
						alert("移除失败！");
					}
				}
			});
	}
});
