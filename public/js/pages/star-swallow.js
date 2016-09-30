$(document).ready(function() {
	
	$(".table tr:nth-child(1)").click(function(e){
		// alert("asasasas");
		// console.log($('this').parent());
		console.log($('this').closest('.table').addClass("disabled"));
		 
	});

	$(".table tr:nth-child(2)").click(function(e){
		alert("bsbsbsbsb");
	});

	$(".table tr:nth-child(3)").click(function(e){
		alert("cscscscscs");
	});

	$(document)
	.on('click', '#pop-submit-btn', function() {
			$.ajax({
				type: 'POST',
				// dataType:'html',
				data: data,
				url: "/teacher/course-evaluation-management",
				success: function(data) {
					// console.log(data);
					$("#addPop").modal('hide');
					$('body').removeClass('modal-open');
					$('.modal-backdrop').remove();
					$("#course-evaluation-management").html(data);
				}
			});
	});

});
