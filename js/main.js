$(function(){
	$(document).on('click','.fc-day',function(){
		var date = $(this).attr('data-date');
		document.location = 'viewactive?date=' + date;
	});
});

$(function(){
	$(document).on('click','.fc-day-number',function(){
		var date = $(this).attr('data-date');
		document.location = 'viewactive?date=' + date;
	});
});

/*
	get the modals
*/

// $(function(){
// 	$(document).on('click','.fc-day',function(){
// 		var date = $(this).attr('data-date');
		// $.get('viewpic',{'date':date},function(data){
		// 	$('#modal').modal('show')
		// 	.find('#modalContent')
		// 	.html(data);
		// }); 
// 	});
// });
