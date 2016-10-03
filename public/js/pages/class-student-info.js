$(document).ready(function() {
	$(".delete-btn").click(function(e){
		if (confirm("确认删除这个学生信息吗？")) {
			var studentsId = $(this).val();
	    	deleteEvaluteItem(studentsId, $(this).closest("tr"));
	  	}
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
