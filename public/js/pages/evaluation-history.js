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
        filterEvaluationHistory();
    });

    $('#week-select').change(function(e) {
        filterEvaluationHistory();
    });

    $('#class-select').change(function(e) {
        filterEvaluationHistory();
    });

    $('#course-select').change(function(e) {
        filterEvaluationHistory();
    });

    $('.item-row').click(function(e){
    	$(this).children('td').eq(0).children(0).attr('checked','checked')
    });

    $("#selectAllPageItem").click(function(e){
    	if ("全选" == $("#selectAllPageItem").text()) {
    		$(".history-item").prop("checked", true);
    		$("#selectAllPageItem").text("取消全选");
    	} else {
    		$(".history-item").prop("checked", false);
    		$("#selectAllPageItem").text("全选");
    	}
    });

    $("#deleteSelectedMultiItem").click(function(e){
    	if (confirm("确认删除这些记录吗？")) {
    		var checkedValues = $('input:checkbox:checked').map(function() {
			    return this;
			}).get();
			console.log(checkedValues);
			for (var i = 0; i < checkedValues.length; i++) {
				deleteEvaluteItem(checkedValues[i].value, $(checkedValues[i]).closest("tr"));
			}
    	}
    });

    $("#clearFilterBtn").click(function(e){
    	$("#week-select").val(0);
        $("#course-select").val(0);
        $("#class-select").val(0);
        $("#filter-student-name").val("");
        filterEvaluationHistory();
    });

    function filterEvaluationHistory()
    {
    	var weekSelect = $("#week-select").val();
        var courseSelect = $("#course-select").val();
        var classSelect = $("#class-select").val();
        var studentNameSelect = $("#filter-student-name").val();

    	var data = { weekSelect : weekSelect, 
    				 classSelect : classSelect, 
    				 courseSelect : courseSelect, 
    				 studentNameSelect : studentNameSelect}
		$.ajax({
				type: 'POST',
				data: data,
				url: "/teacher/ajax-filter-evaluation-history",
				success: function(data) {
					top.location = "/teacher/evaluation-history";
				}
			});
    }
});
