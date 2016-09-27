
$(document).ready(function() {
	$(document)
		.on('click', '.class-btn', function() {
			var data = {classesId : $(this).attr('value')};
			$.ajax({
					type: 'POST',
					data: data,
					url: "/teacher/load-comment-area",
					success: function(data) {
						var response = JSON.parse(data);
						$("#students-selection").html(response.studentsHtml);
						$("#course-btn-group").html(response.courseHtml);
						$("#evaluation-index-btn-group").html(response.evaluationIndexHtmlContent);
						$("#evaluation-detail-btn-group").html(response.evaluationDetailHtmlContent);
						$("#students-selection").removeClass("hidden");
						$("#comment-selection").removeClass("hidden");
						$("#classes-selection").addClass("hidden");
					}
				});
		})
		.on('click', '.student-btn', function() {
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
		})
        .on('click', "div[name='course-btn-group'] label", function() {
        	var coursesId =$(this).children().attr('id'); 
			var data = {
					coursesId : coursesId,
				};
			$.ajax({
					type: 'POST',
					data: data,
					url: "/teacher/ajax-get-course-evaluate-content",
					success: function(data) {
						var response = JSON.parse(data);
						$("#evaluation-index-btn-group").html(response.evaluationIndexHtmlContent);
						$("#evaluation-detail-btn-group").html(response.evaluationDetailHtmlContent);
					}
				});
        })
        .on('click', "div[name='evaluation-index-btn-group'] label", function() {
			var evaluationIndexsId =$(this).children().attr('id'); 
			var data = {
					evaluationIndexsId : evaluationIndexsId,
				};
			$.ajax({
					type: 'POST',
					data: data,
					url: "/teacher/ajax-get-index-evaluate-content",
					success: function(data) {
						$("#evaluation-detail-btn-group").html(data)
					}
				});
        })
        .on('click', '#submit-comment', function() {
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
        })

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