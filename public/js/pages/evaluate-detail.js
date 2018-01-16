$(document).ready(function() {
	$('#student-evaluate-detail-list').bootstrapTable('destroy');

	var coursesId = $("#courses_id").val();
	var usersId = $("#users_id").val();

	$('#student-evaluate-detail-list').bootstrapTable({
        method: 'post', 
        contentType: 'application/x-www-form-urlencoded',
        search: "true",
        url: "/student/getStudentEvaluateDetail",
        pagination:"true",
        pageList: [10, 25, 50], 
        pageSize: 10,
        pageNumber: 1,
        // toolbar:"#toolbar",
    	queryParams: function(params) {
	        var temp = { 
		        coursesId : coursesId,
		        usersId : usersId,
		    };
		    return temp;
    	},
    	clickToSelect: true,
    	columns: [{  
                    title: '序号',
                    formatter: function (value, row, index) {  
                        return index+1;  
                    }  
                }],
        responseHandler: function (res) {
        	// console.log(res);
            return res;
        },
    });
});