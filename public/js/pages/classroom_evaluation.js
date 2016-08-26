$(document).ready(function() {
	$('.class-btn').click(function(e) {
		var data = {classesId : $(this).val()};
		$.ajax({
				type: 'POST',
				// dataType:'html',
				data: data,
				url: "/teacher/classroom-evaluation",
				success: function(data) {
					console.log(data);    
					
					$("#addPop").modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					$("#classroom-evaluation").html(data);
					$("#classes-selection").addClass('hidden');
					$("#students-selection").removeClass('hidden');
				}
			});
	});

	function cleanWarningLabel()
	{
		$('#warning-label').html("");
	}

	function isNeedShowWarningLabel(str)
	{
		if ("" == $('#pop-input').val()) {
			$('#warning-label').html("评价"+str+"不能为空！");
		}
	}
});
