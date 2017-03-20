$(document).ready(function() {

    $('#week-select').change(function(e) {
        filterEvaluationReport();
    });

    $('#class-select').change(function(e) {
        filterEvaluationReport();
    });

    $('#course-select').change(function(e) {
        filterEvaluationReport();
    });

    function filterEvaluationReport()
    {
    	var weekSelect = $("#week-select").val();
        var courseSelect = $("#course-select").val();
        var classSelect = $("#class-select").val();

    	var data = { weekSelect : weekSelect, 
    				 classSelect : classSelect, 
    				 courseSelect : courseSelect}
		$.ajax({
				type: 'POST',
				data: data,
				url: "/teacher/ajax-filter-evaluation-report",
				success: function(data) {
					top.location = "/teacher/evaluation-report";
				}
			});
    }
});
