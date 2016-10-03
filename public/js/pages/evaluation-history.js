$(document).ready(function() {
	$(".delete-btn").click(function(e){
		if (confirm("确认删除这条记录吗？")) {
			var evaluationId = $(this).val();
	    	deleteEvaluteItem(evaluationId, $(this).closest("tr"));
	  	}
	});

	function deleteEvaluteItem(evaluationId, listItem)
	{
		var data = {evaluationId:evaluationId}
		$.ajax({
				type: 'POST',
				data: data,
				url: "/teacher/ajax-delete-evaluate-item",
				success: function(data) {
					listItem.addClass('hidden');
				}
			});
	}
});
