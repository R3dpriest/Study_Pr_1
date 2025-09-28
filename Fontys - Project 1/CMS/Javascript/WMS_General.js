// Global
let current;

$(document).ready(function(){
	$('#WMS_Location').on('change', function() {
		const WMS_Page_name = window.location.pathname.split('/').pop().replace('.php', '');
		$('#CMS_EDI_Sub').empty();
		$.ajax({ url: 'WMS_Inventory_catch.php', type: 'POST', data: { WMS_Inv_Catch: WMS_Inv_Catch, WMS_Page_name: WMS_Page_name },
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
	});
});



