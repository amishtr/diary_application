/**
 * Filename: formOne.php
 * Description: Camera Model - Team Player / Cells Matrix
 * Author: Amish Trivedi, Tomasz Kwiatkowski
 * Date developed: 12-March-2019
 * Version: 1.0
 */

$(document).ready(function() {
	$("#formOne").submit(function(event) {
		$('#error_holder').removeClass('alert alert-dismissible alert-danger'); // remove the error class
		$('.holder').remove(); // remove the error text
		//modelNO = document.getElementById("modelSearchInput").value;
		$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: 'getModelDesc.php', // the url where we want to POST
			data 		: $("#formOne").serialize(),//'&modelNoSecond=' +modelNO, //+ // our data object
			dataType 	: 'json', // what type of data do we expect back from the server
			encode 		: true
		})
		.done(function(data) {

				// log data to the console so we can see
				//console.log(data);

				if (!data.success) {

				// handle errors for name 
					if (data.errors.missing) {
						$('#error_holder').addClass('alert alert-dismissible alert-danger'); // add the error class to show red input
						$('#error_holder').append('<div class="holder"><h4 class="alert-heading">'+data.errors.missing+'</h4></div>'); // add the actual error message under our input
					}
					if (data.errors.notFound) {
						$('#error_holder').addClass('alert alert-dismissible alert-danger'); // add the error class to show red input
						$('#error_holder').append('<div class="holder"><h4 class="alert-heading">'+data.errors.notFound+'</h4></div>'); // add the actual error message under our input
					}
				}
				else{
					document.getElementById("modelDesc").value = data['modelDesc'];
					document.getElementById("modelSearchInput").setAttribute("disabled",true);
					
					// load the model record from the holding table if that model(F number) exists
					if(data.f_no_info_success){	
						$(".pictureHolder").empty();					
						$("#sendButton").html('UPDATE');
						document.getElementById("modelDesc").value = data['modelDesc'];
						$('#tech_primary').val(data['tech_primary']);
						pictureAppend('tech_primary',data['tech_primary']);
						//document.getElementById("tech_primary").value = data['tech_primary'];
						$('#tech_secondary').val(data['tech_secondary']);
						pictureAppend('tech_secondary',data['tech_secondary']);
						//document.getElementById("tech_secondary").value = data['tech_secondary'];
						$('#tech_backup').val(data['tech_backup']);
						pictureAppend('tech_backup',data['tech_backup']);
						//document.getElementById("tech_backup").value = data['tech_backup'];
						$('#op_primary').val(data['op_primary']);
						//document.getElementById("op_primary").value = data['op_primary'];
						$('#op_secondary').val(data['op_secondary']);
						//document.getElementById("op_secondary").value = data['op_secondary'];
						$('#op_backup').val(data['op_backup']);
						//document.getElementById("op_backup").value = data['op_backup'];
						$('#op_build_cell_1').val(data['op_build_cell_1']);
						//document.getElementById("op_build_cell_1").value = data['op_build_cell_1'];
						$('#op_build_cell_2').val(data['op_build_cell_2']);
						//document.getElementById("op_build_cell_2").value = data['op_build_cell_2'];
						$('#op_build_cell_3').val(data['op_build_cell_3']);
						//document.getElementById("op_build_cell_3").value = data['op_build_cell_3'];
						$('#op_test_cell_1').val(data['op_test_cell_1']);
						//document.getElementById("op_test_cell_1").value = data['op_test_cell_1'];
						$('#op_test_cell_2').val(data['op_test_cell_2']);
						//document.getElementById("op_test_cell_2").value = data['op_test_cell_3'];
						$('#op_test_cell_3').val(data['op_test_cell_3']);
						//document.getElementById("op_test_cell_3").value = data['op_test_cell_3'];
						$("#deleteButton").show();
					}
					else{
						$("#sendButton").html('SAVE');
					}					
				}
			})

			// using the fail promise callback
			.fail(function(data) {
				//console.log(data);
				$('#error_holder').addClass('alert alert-dismissible alert-danger'); // add the error class to show red input
				$('#error_holder').append('<div class="holder" ><h4 class="alert-heading">ERROR! Something went wrong. Please input a valid F number to search.</h4></div>');
			});

		event.preventDefault();
	});
});