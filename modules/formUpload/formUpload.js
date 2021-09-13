$(function(){
	$("#jsUpload").on('click', function(){
		
		console.log("upload function init");
		
		var file_data = $('#jsClientFile').prop('files')[0];   
		var form_data = new FormData();				  
		form_data.append('file', file_data);
		
		console.log(form_data);
		
		$.ajax({
			url: '/modules/formUpload/formUpload.php', // point to server-side PHP script 
			dataType: 'text',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,						 
			type: 'post',
			success: function(php_script_response){
				alert(php_script_response); // display response from the PHP script, if any
			}
		});
	});
});