$(document).ready(function() {
	$('#today-btn').click(function(e) {
		if ($('#today-btn').hasClass("active")) {
			$('#today-btn').removeClass("active");
		} else {
			$('#today-btn').addClass("active");
		}
        filterEvaluationReport();
    });

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
    	var todaySelect = $('#today-btn').hasClass("active");
    	var weekSelect = $("#week-select").val();
        var courseSelect = $("#course-select").val();
        var classSelect = $("#class-select").val();

    	var data = { todaySelect : todaySelect,
    				 weekSelect : weekSelect, 
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
