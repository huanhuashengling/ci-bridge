$(document).ready(function() {
	$(document)
	.on('click', '#add-index-btn', function() {
		cleanWarningLabel();
		$('#pop-title').html("增加评价指标");
		$('#pop-submit-btn').html("增加");
		$('#pop-input').removeClass("hidden");
		$('#current-operate').val("add-index");
		$('#addPop').modal('show');
	})

	.on('click', '.edit-index-btn', function() {
		cleanWarningLabel();
		$('#pop-title').html("编辑评价指标");
		$('#pop-submit-btn').html("编辑");
		$('#pop-input').removeClass("hidden");
		$('#current-operate').val("edit-index");
		$('#current-index-id').val($(this).val());
		$('#pop-input').val($(this).closest('tr').attr('name'));
		$('#addPop').modal('show');
	})

	.on('click', '.del-index-btn', function() {
		cleanWarningLabel();
		$('#pop-title').html("确认删除当前评价指标吗？");
		$('#pop-submit-btn').html("删除");
		$('#pop-input').addClass("hidden");
		$('#current-operate').val("del-index");
		$('#current-index-id').val($(this).val());
		$('#addPop').modal('show');
	})

	.on('click', '.add-detail-btn', function() {
		cleanWarningLabel();
		$('#pop-title').html("增加评价细则");
		$('#pop-submit-btn').html("增加");
		$('#pop-input').removeClass("hidden");
		$('#current-operate').val("add-detail");
		$('#current-index-id').val($(this).val());
		$('#addPop').modal('show');
	})

	.on('click', '.edit-detail-btn', function() {
		cleanWarningLabel();
		$('#pop-title').html("编辑评价细则");
		$('#pop-submit-btn').html("编辑");
		$('#pop-input').removeClass("hidden");
		$('#current-operate').val("edit-detail");
		$('#current-detail-id').val($(this).val());
		$('#pop-input').val($(this).closest('tr').attr('name'));
		$('#addPop').modal('show');
	})

	.on('click', '.del-detail-btn', function() {
		cleanWarningLabel();
		$('#pop-title').html("确认删除评价细则吗？");
		$('#pop-submit-btn').html("删除");
		$('#pop-input').addClass("hidden");
		$('#current-operate').val("del-detail");
		$('#current-detail-id').val($(this).val());
		$('#addPop').modal('show');
	})

	.on('click', '#pop-submit-btn', function() {
		cleanWarningLabel();
		var data = {coursesId : $('#courses-id').val(), currentOperate : $('#current-operate').val()};
		switch ($("#current-operate").val())
		{
			case "add-index":
				isNeedShowWarningLabel("指标");
				data.indexDescription = $('#pop-input').val();
			break;
			case "edit-index":
				isNeedShowWarningLabel("指标");
				data.indexDescription = $('#pop-input').val();
				data.indexId = $('#current-index-id').val();
			break;
			case "del-index":
				data.indexId = $('#current-index-id').val();
			break;
			case "add-detail":
				isNeedShowWarningLabel("细则");
				data.indexId = $('#current-index-id').val();
				data.detailDescription = $('#pop-input').val();
			break;
			case "edit-detail":
				isNeedShowWarningLabel("细则");
				data.detailId = $('#current-detail-id').val();
				data.detailDescription = $('#pop-input').val();
			break;
			case "del-detail":
				data.detailId = $('#current-detail-id').val();
			break;
		}
		// console.log(data);
		// alert("asasas");
		if ("" == $('#warning-label').html()) {
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
		}
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
