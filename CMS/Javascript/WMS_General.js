// Global
let current;

$(document).ready(function(){
	$('#WMS_Location').on('change', function(){
		const WMS_Page_name = window.location.pathname.split('/').pop().replace('.php', '');
		$('#CMS_EDI_Sub').empty();
		$.ajax({ url: 'WMS_Inventory_catch.php', type: 'POST', dataType: 'json', data:{ WMS_Inv_Catch: WMS_Inv_Catch, WMS_Page_name: WMS_Page_name },
			success: function(response){
				$('#WMS_INV_Xdata').html(response.ExtrData);
				$('#WMS_INV_inventory').html(response.InvData);
			},
			error: function(xhr, status, error) {
				console.error('Update error: ', error);
			}
		});
	});
	$('.WMS_Inv_Handle').on('click', function() {
	var WMS_Inv_ID = this.id.replace(/WMS_Inv_I_/g, "");
	var WMS_Inv_Resel = $('#WMS_INV_OPT_SEL').val();
	var WMS_Location = $('#WMS_Location').val();

	$.ajax({ url: 'WMS_Inventory_catch.php', type: 'POST', dataType: 'json', data:{ WMS_Inv_Resel: WMS_Inv_Resel, WMS_Inv_ID: WMS_Inv_ID, WMS_Location: WMS_Location },
        success: function(response){
			$('#WMS_INV_h2').html(response.Title);
			$('#WMS_INV_tab').html(response.Data);
        },
        error: function(xhr, status, error){
            console.error('Update error:', error);
        }
    });
});
	$('#WMS_SB_AD').on('click', function(){ window.location.href = "Audit.php"; });
	$('#WMS_SB_RE').on('click', function(){ window.location.href = "Recipy.php"; });
	$('#WMS_SB_AL').on('click', function(){ window.location.href = "Analysis.php"; });
	$('#WMS_SB_SL').on('click', function(){ window.location.href = "ShelfLife.php"; });

});



