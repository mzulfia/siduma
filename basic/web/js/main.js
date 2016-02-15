$(function(){
	$(document).on('click','.fc-day',function(){
		var date = $(this).attr('data-date');

		$.get('create',{'date':date},function(data){
			$('#modal').modal('show')
			.find('#modalContent')
			.html(data);
		}); 
	});
});