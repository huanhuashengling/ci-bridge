
$(document).ready(function() {
	$('.student-btn').click(function(e){
		if ("boy" == $(this).attr('gender')) {
			if ($(this).hasClass('btn-primary')) {
				$(this).removeClass('btn-primary');
				$(this).addClass('btn-success');
			} else if ($(this).hasClass('btn-success')) {
				$(this).removeClass('btn-success');
				$(this).addClass('btn-primary');
			}
		}
		if ("girl" == $(this).attr('gender')) {
			if ($(this).hasClass('btn-danger')) {
				$(this).removeClass('btn-danger');
				$(this).addClass('btn-success');
			} else if ($(this).hasClass('btn-success')) {
				$(this).removeClass('btn-success');
				$(this).addClass('btn-danger');
			}
		}
	});

	$("div[name='course-btn-group'] label").click(function(e){
		// console.log($(this).children().attr('id'));
	});

	$("div[name='evaluation-index-btn-group'] label").click(function(e){
		// console.log($(this).children().attr('id'));
	});

	$('#submit-comment').click(function(e) {
		var studentsIds = $.map($('.btn-success'), function(element) {
		  return $(element).val();
		});
		if (0 == studentsIds.length) {
			alert("请选择学生");
			return;
		}
		var coursesId = $("div[name='course-btn-group'] .active").children().attr('id');
		if (!coursesId) {
			alert("请选择课程");
			return;
		}
		var evaluationIndexsId = $("div[name='evaluation-index-btn-group'] .active").children().attr('id');
		if (!evaluationIndexsId) {
			alert("请选择评价指标");
			return;
		}
		var evaluationDetailsId = $("div[name='evaluation-detail-btn-group'] .active").children().attr('id');
		if (!evaluationDetailsId) {
			alert("请选择评价细则");
			return;
		}
		var evaluationLevel = $("div[name='level-btn-group'] .active").children().attr('id');
		if (!evaluationLevel) {
			alert("请选择评价等级");
			return;
		}
		var data = {
				studentsIds : studentsIds,
				coursesId : coursesId,
				evaluationIndexsId : evaluationIndexsId,
				evaluationDetailsId : evaluationDetailsId,
				evaluationLevel : evaluationLevel
			};
		$.ajax({
				type: 'POST',
				data: data,
				url: "/teacher/submit-evaluation",
				success: function(data) {
					if ("true" ==data) {
						alert("添加评价成功！");
					} else {
						alert("添加评价失败！");
					}
					resetStudentsSelection();
				}
			});
	});

	function resetStudentsSelection()
	{
		$('.student-btn').each(function(e){
			if ("girl" == $(this).attr("gender")) {
				$(this).removeClass('btn-success');
				$(this).addClass('btn-danger');
			} else if ("boy" == $(this).attr("gender")) {
				$(this).removeClass('btn-success');
				$(this).addClass('btn-primary');
			}
		});
	}
});
