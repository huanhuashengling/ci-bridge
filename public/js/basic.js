$(document).ready(function(evt){
	$(document)
        .on('click', '.nav-btn', function() {
			alert($(this).hasClass("active"));
			$(".nav-btn").removeClass("active");
			$(this).addClass("active");
			alert($(this).hasClass("active"));
        });
	// $(".nav-btn").click(function(e){
	// 	alert($(this).hasClass("active"));
	// 	$(".nav-btn").removeClass("active");
	// 	$(this).addClass("active");
	// 	alert($(this).hasClass("active"));

	// });
});