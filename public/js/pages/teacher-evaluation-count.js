$(document).ready(function() {
	$('#week-select').change(function(e) {
		var data = {weekNum : $(this).val(), export : false};
    	$.ajax({
			type: 'POST',
			data: data,
			url: "/school/ajax-get-teacher-evaluation-count",
			success: function(data) {
				$("#teacher-evaluate-list").html(data);
			}
		});
	});
	$(document)
	.on('click', '.export-btn', function() {
			var data = {weekNum : $("#week-select").val(), export : "true"};
			$.ajax({
				type: 'POST',
				data: data,
				url: "/school/ajax-get-teacher-evaluation-count",
				success: function(data) {
					console.log(data);
				}
			});
	});
});
