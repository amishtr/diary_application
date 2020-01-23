/**
 * Filename: formTwo.php
 * Description: Camera Model - Team Player / Cells Matrix
 * Author: Amish Trivedi, Tomasz Kwiatkowski
 * Date developed: 12-March-2019
 * Version: 1.0
 */

$(document).ready(function() {
	$("#formTwo").submit(function(event) {
		$('#error_holder').removeClass('alert alert-dismissible alert-danger'); // remove the error class
		$('.holder').remove(); // remove the error text
		modelNO = document.getElementById("modelSearchInput").value;
		modelDesc = document.getElementById("modelDesc").value;
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: 'getModelData.php', // the url where we want to POST
			data 		: $("#formTwo").serialize() + '&modelNo=' + modelNO  + '&modelDescription=' + modelDesc, //+ // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true
		})
		.done(function(data) {

				// log data to the console so we can see
				
					console.log(data);
				if (!data.success) {

					if (data.errors) {
						$('#error_holder').addClass('alert alert-dismissible alert-danger'); // add the error class to show red input
						$('#error_holder').append('<div class="holder"><h4 class="alert-heading">'+data.errors+'</h4></div>'); // add the actual error message under our input
					}
				}
				else{
					$('select').val("");
					$(".pictureHolder").empty();
					document.getElementById("modelDesc").value ="";
					document.getElementById("modelSearchInput").value ="";
					$("#modelSearchInput").removeAttr("disabled");
					$('#error_holder').addClass('alert alert-dismissible alert-success'); // add the error class to show red input
					if(data.error_code == 1)
					$('#error_holder').append('<div class="holder"><h4 class="alert-heading">SUCCESS! The data has been updated in system database.</h4></div>');
					else $('#error_holder').append('<div class="holder"><h4 class="alert-heading">SUCCESS! The updated data has been saved in system database.</h4></div>'); // add the actual error message under our input		
				}
			})

			// using the fail promise callback
			.fail(function(data) {
				console.log(data);
				
				$('#error_holder').addClass('alert alert-dismissible alert-danger'); // add the error class to show red input
				$('#error_holder').append('<div class="holder"><h4 class="alert-heading">ERROR! Something went wrong. Please try again.</h4></div>');
			});

		event.preventDefault();
	});
});