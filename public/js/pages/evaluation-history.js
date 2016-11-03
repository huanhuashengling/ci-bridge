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

	$('#searchBtn').click(function(e) {
        var weekSelect = $("#week-select").val();
        var courseSelect = $("#course-select").val();
        var classSelect = $("#class-select").val();
        filterEvaluationHistory(weekSelect, classSelect, courseSelect);
    });

    $('#week-select').change(function(e) {
        var weekSelect = $("#week-select").val();
        var courseSelect = $("#course-select").val();
        var classSelect = $("#class-select").val();
        filterEvaluationHistory(weekSelect, classSelect, courseSelect);
    });

    $('#class-select').change(function(e) {
        var weekSelect = $("#week-select").val();
        var courseSelect = $("#course-select").val();
        var classSelect = $("#class-select").val();
        filterEvaluationHistory(weekSelect, classSelect, courseSelect);
    });

    $('#course-select').change(function(e) {
        var weekSelect = $("#week-select").val();
        var courseSelect = $("#course-select").val();
        var classSelect = $("#class-select").val();
        filterEvaluationHistory(weekSelect, classSelect, courseSelect);
    });

    function filterEvaluationHistory(weekSelect, classSelect, courseSelect)
    {
    	var data = {weekSelect : weekSelect, classSelect : classSelect, courseSelect : courseSelect}
		$.ajax({
				type: 'POST',
				data: data,
				url: "/teacher/ajax-filter-evaluation-history",
				success: function(data) {
					location.reload();
				}
			});
    }
});
