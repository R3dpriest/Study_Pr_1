$(document).ready(function() {
	//Update all fields for forms
	$('#CMS_EDI_ES1').on('click', function() {
		var CMS_EDI_E1 = $('#CMS_EDI_E1').html();
		var CMS_EDI_E2 = $('#CMS_EDI_E2').val();
		var CMS_EDI_E3 = $('#CMS_EDI_E3').val();
		var CMS_EDI_E4 = $('#CMS_EDI_E4').val();
		$.ajax({url: 'CMS_EDI_Catch.php', type: 'POST', 
			data: { CMS_EDI_E1: CMS_EDI_E1, CMS_EDI_E2: CMS_EDI_E2, CMS_EDI_E3: CMS_EDI_E3, CMS_EDI_E4: CMS_EDI_E4 },
			success: function(response) {
			console.log('Server response:', response);
			},
			error: function(xhr, status, error) {
			console.error('Update error: ', error);
			}
		});
	});
	//Grab the select Form to update
	$('#CMS_GrabAllForms').on('change', function() {
		$('#CMS_EDI_Sub').empty();
		var CMS_Sel_Fo1 = $(this).val();
		if (CMS_Sel_Fo1) {
		$.ajax({ url: 'CMS_EDI_Catch.php', type: 'POST', data: { CMS_Sel_Fo1: CMS_Sel_Fo1 },
			success: function(response){
				var output = response.split("»");
					$('#CMS_EDI_E1').html(output[0]);
					$('#CMS_EDI_E2').val(output[1]);
					$('#CMS_EDI_E3').val(output[2]);
					$('#CMS_EDI_E4').val(output[3]);
					$('#CMS_EDI_E5').html(output[4]);
					$('#CMS_EDI_Sub').html(output[5]);
				},
				error: function(xhr, status, error) {
					console.error('Update error: ', error);
				}
			});
		}
	});
	$('#CMS_GrabAllForm_Fields').on('change', function() {
		$('#CMS_EDI_Sub').empty();
		var CMS_Sel_Fo = $(this).val();
		if (CMS_Sel_Fo) {
		$.ajax({ url: 'CMS_EDI_Catch.php', type: 'POST', data: { CMS_Sel_Fo: CMS_Sel_Fo },
			success: function(response){
				var output = response.split("»");
					$('#CMS_EDI_E1').html(output[0]);
					$('#CMS_EDI_E2').val(output[1]);
					$('#CMS_EDI_E3').val(output[2]);
					switch(output[3]){
						case "text":
							$('#CMS_EDI_E4').val('0');
						break;
						case "textarea":
							$('#CMS_EDI_E4').val('1');
						break;
						case "email":
							$('#CMS_EDI_E4').val('2');
						break;
						case "checkbox":
							$('#CMS_EDI_E4').val('3');
						break;
						case "radio":
							$('#CMS_EDI_E4').val('4');
						break;
						case "button":
							$('#CMS_EDI_E4').val('5');
						break;
						case "number":
							$('#CMS_EDI_E4').val('6');
						break;						
					}
					$('#CMS_EDI_E5').html(output[4]);
					$('#CMS_EDI_E6').html(output[5]);
					switch(output[6]){
						case "true":
							$('#CMS_EDI_E7').val('true');
						break;
						case "false":
							$('#CMS_EDI_E7').val('false');
						break;
					}
					$('#CMS_EDI_E8').html(output[7]);
					$('#CMS_EDI_Sub').html(output[8]);
				},
				error: function(xhr, status, error) {
					console.error('Update error: ', error);
				}
			});
		}
	});
});