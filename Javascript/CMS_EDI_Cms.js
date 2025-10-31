let BufferVal1 = ""; 
$(document).ready(function(){
	var $CMS_EDI_Lang_Sel = $('#CMS_EDI_Lang_sub');	if ($CMS_EDI_Lang_Sel.length){$CMS_EDI_Lang_Sel.prepend('<option selected hidden value="99999">Select</option>'); $CMS_EDI_Lang_Sel.prop('selectedIndex', 0); }
	var $CMS_Field_Lang_2 = $('#CMS_Field_Lang_2'); if ($CMS_Field_Lang_2.length){$CMS_Field_Lang_2.prepend('<option selected hidden value="99999">Select</option>'); $CMS_Field_Lang_2.prop('selectedIndex', 0); }
	var $CMS_Field_Lang_1 = $('#CMS_Field_Lang_1'); if ($CMS_Field_Lang_1.length){$CMS_Field_Lang_1.prepend('<option selected hidden value="99999">Select</option>'); $CMS_Field_Lang_11.prop('selectedIndex', 0); }
	var $CMS_EDI_SUB_SEL = $('#CMS_EDI_SUB_SEL'); if ($CMS_EDI_SUB_SEL.length){	$CMS_EDI_SUB_SEL.prop('selectedIndex', 0); 	}
	var $CMS_EDI_F3 = $('#CMS_EDI_F3'); if ($CMS_EDI_F3.length){$CMS_EDI_F3.prepend('<option selected hidden value="99999">Select</option>'); $CMS_EDI_F3.prop('selectedIndex', 0); }
	var $CMS_EDI_F2 = $('#CMS_EDI_F2'); if ($CMS_EDI_F2.length){$CMS_EDI_F2.prepend('<option selected hidden value="99999">Select</option>'); $CMS_EDI_F2.prop('selectedIndex', 0); }
	var $CMS_SUB_Typ = $('#CMS_SUB_Typ'); if ($CMS_SUB_Typ.length){$CMS_SUB_Typ.prepend('<option selected hidden value="99999">Select</option>'); $CMS_SUB_Typ.prop('selectedIndex', 0); }
	var $CMS_EDI_Y4 = $('#CMS_EDI_Y4'); if ($CMS_EDI_Y4.length){$CMS_EDI_Y4.prepend('<option selected hidden value="99999">Select</option>'); $CMS_EDI_Y4.prop('selectedIndex', 0); }
	var $CMS_EDI_Y6 = $('#CMS_EDI_Y6'); if ($CMS_EDI_Y6.length){$CMS_EDI_Y6.prepend('<option selected hidden value="99999">Select</option>'); $CMS_EDI_Y6.prop('selectedIndex', 0); }
	var $CMS_EDI_Y7 = $('#CMS_EDI_Y7'); if ($CMS_EDI_Y7.length){$CMS_EDI_Y7.prepend('<option selected hidden value="99999">Select</option>'); $CMS_EDI_Y7.prop('selectedIndex', 0); }
	var $CMS_SUB_Typ = $('#CMS_SUB_Typ'); if ($CMS_SUB_Typ.length){$CMS_SUB_Typ.prepend('<option selected hidden value="99999">Select</option>'); $CMS_SUB_Typ.prop('selectedIndex', 0); }
	
	
	
	
	$(function(){
		$( ".CMS_Sort" ).sortable({
			placeholder: "ui-state-highlight"
		});
		$( "#CMS_Sort" ).disableSelection();
	});
	
	//Q=1
	$('#CMS_Form_field_1').on('change',function(){
		const CMS_Sel_Fo1 = $(this).val();
		if(CMS_Sel_Fo1){
			$.ajax({url:'CMS_EDI_Catch.php',type:'POST',data:{CMS_Sel_Fo1},
			success:function(response){
				const output = response.split("»");
				$('#CMS_EDI_E1').html(output[0]);
				$('#CMS_EDI_E2').val(output[1]);
				$('#CMS_EDI_E3').val(output[2]);
				$('#CMS_EDI_E4').val(output[3]);
				$('#CMS_EDI_E5').html(output[4]);
				$('#CMS_EDI_SUB_SEL').html(output[5]);
				$('#CMS_EDI_Tog').fadeIn(400);
				$CMS_EDI_SUB_SEL.prepend('<option selected hidden value="99999">Select</option>');
				$CMS_EDI_SUB_SEL.prop('selectedIndex', 0);
			},
			error:function(xhr,status,error){console.error('Update error:',error);}
			});
			$('#CMS_SUB_ID').html('');	$('#CMS_SUB_FID').html('');	$('#CMS_SUB_Key').val('');	$('#CMS_SUB_Req').val('99999');
			$('#CMS_SUB_Ank').val('');	$('#CMS_SUB_Typ').val('99999');	$('#CMS_SUB_Dis').val('');	$('#CMS_SUB_Ord').val('0');
		}
	});
	$('.CMS_EDI_Q_1').on('change',function(){
		const CMS_Sel_FoE1 = $(this).val();
		if(CMS_Sel_FoE1){
			$.ajax({url:'CMS_EDI_Catch.php', type:'POST', dataType: 'json', data:{CMS_Sel_FoE1},
				success:function(response){
					$.each(response, function(key, value){
						var $CMS_Outp = $('#' + key);
						if ($CMS_Outp.is('input, textarea, select')) {
							$CMS_Outp.val(value);
						} else {
							$CMS_Outp.text(value);
						}
					});
					
				},
			error:function(xhr,status,error){console.error('Update error:',error);}
			});
		}
	});
	$('#CMS_EDI_ES1').on('click',function(){
		const CMS_YF = "1";
		const CMS_EDI_E0 = $('#CMS_EDI_E0').val();
		const CMS_EDI_E1 = $('#CMS_EDI_E1').html();
		const CMS_EDI_E2 = $('#CMS_EDI_E2').val();
		const CMS_EDI_E3 = $('#CMS_EDI_E3').val();
		const CMS_EDI_E4 = $('#CMS_EDI_E4').val();
		const CMS_EDI_E5 = $('#CMS_EDI_E5').val();
		$.ajax({url:'CMS_EDI_Catch.php',type:'POST',
		data:{CMS_YF,CMS_EDI_E0,CMS_EDI_E1,CMS_EDI_E2,CMS_EDI_E3,CMS_EDI_E4,CMS_EDI_E5},
			success:function(response){$('#CMS_EDI_ES1').html('succes');
			setTimeout(()=>{ $('#CMS_EDI_ES1').html('update'); }, 2500);},
			error:function(xhr,status,error){console.error('Update error:',error);}
		});
	});
	$('#CMS_EDI_Update1').on('click',function(){
		const CMS_YFA = "1";
		const CMS_EDI_E0 = $('#CMS_EDI_E0').val();
		const CMS_EDI_E1 = $('#CMS_SUB_ID').html();
		const CMS_EDI_E2 = $('#CMS_SUB_FID').html();
		const CMS_EDI_E3 = $('#CMS_SUB_Key').val();
		const CMS_EDI_E4 = $('#CMS_SUB_Typ').val();
		const CMS_EDI_E5 = $('#CMS_SUB_Ank').val();
		const CMS_EDI_E6 = $('#CMS_SUB_Dis').val();
		const CMS_EDI_E7 = $('#CMS_SUB_Req').val();
		const CMS_EDI_E8 = $('#CMS_SUB_Ord').val();
		$.ajax({url:'CMS_EDI_Catch.php',type:'POST',
		data:{CMS_YFA,CMS_EDI_E0,CMS_EDI_E1,CMS_EDI_E2,CMS_EDI_E3,CMS_EDI_E4,CMS_EDI_E5,CMS_EDI_E6,CMS_EDI_E7,CMS_EDI_E8},
			success:function(response){$('#CMS_EDI_Update1').html('succes');
			setTimeout(()=>{ $('#CMS_EDI_Update1').html('update'); }, 2500);
			console.log('Server response:',response);
			},
			error:function(xhr,status,error){console.error('Update error:',error);}
		});
	});
	
	
	
	//Q=2
	$('#CMS_Field_Lang_2').on('change',function(){
		$('#CMS_EDI_Sub').empty();
		const CMS_Sel_Fo2 = $(this).val();
		if(CMS_Sel_Fo2){
			$.ajax({url:'CMS_EDI_Catch.php', type:'POST', dataType: 'json', data:{CMS_Sel_Fo2},
				success:function(response){
					$.each(response, function(key, value){
						var $CMS_Outp = $('#' + key);
						if ($CMS_Outp.is('input, textarea, select')) {
							$CMS_Outp.val(value);
						} else {
							$CMS_Outp.text(value);
						}
					});
					$('#CMS_EDI_Tog').fadeIn(400);
					$('#CMS_EDI_Lang_sub option').prop('disabled', true);
					$.each(response.CMS_Lang_Sel, function(CMS_EDI_Un_handle, CMS_EDI_Un_Data){
						$('#CMS_EDI_Lang_sub option[value="' + CMS_EDI_Un_handle + '"]').prop('disabled', false);
					});
					$('#CMS_EDI_F1').html('');	$('#CMS_EDI_F2').val("99999");	$('#CMS_EDI_F3').val("99999");
					$('#CMS_EDI_F4').val('');	$('#CMS_EDI_F5').val('');	$('#CMS_EDI_F6').val('');
				},
			error:function(xhr,status,error){console.error('Update error:',error);}
			});
			
		}
	});
	$('#CMS_EDI_Lang_sub').on('change',function(){
		$('#CMS_EDI_Sub').empty();
		const CMS_Sel_FoE2 = $(this).val();
		const CMS_Sel_FoA2 = $('#CMS_Field_Lang_2').val();
		if(CMS_Sel_FoE2){
			$.ajax({url:'CMS_EDI_Catch.php', type:'POST', dataType: 'json', data:{CMS_Sel_FoE2, CMS_Sel_FoA2},
				success:function(response){
					console.log(response);
					$.each(response, function(key, value){
						var $CMS_Outp = $('#' + key);
						if ($CMS_Outp.is('input, textarea, select')) {
							$CMS_Outp.val(value);
						} else {
							$CMS_Outp.text(value);
						}
					});
				},
			error:function(xhr,status,error){console.error('Update error:',error);}
			});
		}
	});
	
	
	
	
	$('#CMS_EDI_ES3').on('click',function(){
	const CMS_YF = "3";
	const CMS_EDI_E1 = $('#CMS_EDI_E1').html();
	const CMS_EDI_E2 = $('#CMS_EDI_E2').val();
	const CMS_EDI_E3 = $('#CMS_EDI_E3').val();
	const CMS_EDI_E4 = $('#CMS_EDI_E4').val();
	const CMS_EDI_E5 = $('#CMS_EDI_E5').val();
	const CMS_EDI_E6 = $('#CMS_EDI_E6').val();
	const CMS_EDI_E7 = $('#CMS_EDI_E7').val();
	const CMS_EDI_E8 = $('#CMS_EDI_E8').val();
	const CMS_EDI_E9 = $('#CMS_EDI_E9').val();
	$.ajax({url:'CMS_EDI_Catch.php',type:'POST',
	data:{CMS_YF,CMS_EDI_E1,CMS_EDI_E2,CMS_EDI_E3,CMS_EDI_E4,CMS_EDI_E5,CMS_EDI_E6,CMS_EDI_E7,CMS_EDI_E8,CMS_EDI_E9},
	success:function(response){console.log('Server response:',response);},
	error:function(xhr,status,error){console.error('Update error:',error);}
	});
	});
});