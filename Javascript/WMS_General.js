// Global
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
	
	
	// staffing.php
	$('#WMS_Ros_loc').on('change', function(){
		let a = "L";
		let b = $(this).val();
		CMS_Reload_get(a, b);
	});
	$('#WMS_UpD').on('click', function(){
		WMS_Roster_Array();
	/*	const WMS_PassArray = WMS_Roster_Array();
		console.log('Raw output:', WMS_PassArray);
		console.log('Stringified:', JSON.stringify(WMS_PassArray, null, 2));*/

	});
	CMS_Cal_Gen(currentDate);
	$(document).on('click','.CMS_Dup',function(){
		let $CMS_Dup1=$(this).parent().parent().parent().clone();
		let $CMS_Dup2=$('#WMS_Cal_Ava');
		let CMS_Dup3=$CMS_Dup1.attr('data-id');
		if(!$CMS_Dup2.find(`[data-id="${CMS_Dup3}"]`).length){
			$CMS_Dup2.append($CMS_Dup1);
		}
	});
			
});

const currentDate = new Date();

//stackexchange help
function CMS_Cal_Gen(date) {
	const year = date.getFullYear();	const month = date.getMonth();	const firstDay = new Date(year, month, 1);
	const lastDay = new Date(year, month + 1, 0);	const startDay = firstDay.getDay(); // 0 (Sun) to 6 (Sat)

	const $CMS_Cal_Grid = $('#CMS_Cal_Grid');	const $CMS_Mo_Ye = $('#CMS_Mo_Ye');	const $weekNumber = $('#weekNumber');
	const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
	$CMS_Cal_Grid.empty();

	$.each(daysOfWeek, function(_, day){	const $dayElem = $('<div>').addClass('CMS_Cal_Day').text(day);	$CMS_Cal_Grid.append($dayElem); });
	for(let i = 0; i < startDay; i++){ $CMS_Cal_Grid.append($('<div>'));}
	for(let d = 1; d <= lastDay.getDate(); d++){
		const fullDate = new Date(year, month, d);	const mysqlDate = fullDate.toISOString().split('T')[0];
		const $dateElem = $('<div>').addClass('CMS_Cal_Date').text(d).on('click', function(){
			// https://www.w3schools.com/jsref/jsref_encodeURIComponent.asp
			const WMS_BASE_URL = new URL(window.location.href);
			const WMS_BASE_URL_PART = WMS_BASE_URL.origin + WMS_BASE_URL.pathname;
			const WMS_BASE_URL_L = WMS_BASE_URL.searchParams.get('L');
			let WMS_NEW_URL = WMS_BASE_URL_PART;
			if(WMS_BASE_URL_L !== null){
				WMS_NEW_URL += '?L=' + encodeURIComponent(WMS_BASE_URL_L) + '&X=' + encodeURIComponent(mysqlDate);
			} else {
				WMS_NEW_URL += '?X=' + encodeURIComponent(mysqlDate);
			}
			window.location.href = WMS_NEW_URL;
		});
		$CMS_Cal_Grid.append($dateElem);
	}
	$CMS_Mo_Ye.text(firstDay.toLocaleString('default', { month: 'long' }) + ' ' + year);
	const weekNum = CMS_Cal_WeNr(firstDay);
	$weekNumber.text('Week ' + weekNum);
}

function CMS_Cal_CM(offset){currentDate.setMonth(currentDate.getMonth() + offset); CMS_Cal_Gen(currentDate); }
function CMS_Cal_WeNr(d){	d = new Date(Date.UTC(d.getFullYear(), d.getMonth(), d.getDate()));	d.setUTCDate(d.getUTCDate() + 4 - (d.getUTCDay() || 7));
	const yearStart = new Date(Date.UTC(d.getUTCFullYear(), 0, 1));		const weekNo = Math.ceil((((d - yearStart) / 86400000) + 1) / 7);	return weekNo;
}

$(function(){$(".WMS_Cal_Sort").sortable({ connectWith: ".WMS_Cal_Sort", placeholder: "WMS_So_Place" }).disableSelection();});

const WMS_Days = {mon: '#WMS_Mon', tue: '#WMS_Tue', wed: '#WMS_Wed', thu: '#WMS_Thu', fri: '#WMS_Fri', sat: '#WMS_Sat', sun: '#WMS_Sun'};
function WMS_Roster_Array(){
	const Entry_Data = [];
	Object.keys(WMS_Days).forEach(DayS => {
		const WMS_Containers = $(WMS_Days[DayS]);
		if(!WMS_Containers.length) return;
		WMS_Containers.find('li').each(function(){
			const WMS_User = parseInt($(this).data('id'), 10);
			let WMS_Role = null;
			const WMS_Role_sel = $(this).find('select');
			if(WMS_Role_sel.length){
				WMS_Role = parseInt(WMS_Role_sel.val(), 10);
			} else {
				console.log('Data input error. Role selection was incorrect'); location.reload(); return false;
			}
			if(!Number.isFinite(WMS_User)) return;
			Entry_Data.push({prof_id: WMS_User, role_id: WMS_Role, day: DayS});
		});
	});
	const WMS_unique = {};
	Entry_Data.forEach(function(Unit){ // cycle through the collected data 
	const WMS_Constraint = WMS_SelWeek + '_' + Unit.role_id + '_' + Unit.prof_id;
	if(!WMS_unique[WMS_Constraint]) {
		WMS_unique[WMS_Constraint] = {
		weeks_id: WMS_SelWeek, role_id: Unit.role_id, prof_id: Unit.prof_id, loc_id: loc_id,
		day_mon: false,	day_tue: false,	day_wed: false,	day_thu: false,
		day_fri: false,	day_sat: false,	day_sun: false
	  };
	}
	if (Unit.day === 'mon') WMS_unique[WMS_Constraint].day_mon = true;
		else if (Unit.day === 'tue') WMS_unique[WMS_Constraint].day_tue = true;
		else if (Unit.day === 'wed') WMS_unique[WMS_Constraint].day_wed = true;
		else if (Unit.day === 'thu') WMS_unique[WMS_Constraint].day_thu = true;
		else if (Unit.day === 'fri') WMS_unique[WMS_Constraint].day_fri = true;
		else if (Unit.day === 'sat') WMS_unique[WMS_Constraint].day_sat = true;
		else if (Unit.day === 'sun') WMS_unique[WMS_Constraint].day_sun = true;
	});
	const WMS_PassArray = Object.values(WMS_unique);
	$.ajax({
		url: 'WMS_Staffing_catch.php', type: 'POST', data: { roster: JSON.stringify(WMS_PassArray) },
		success: function(response){
		console.log('Server response:', response);
		},
		error: function(xhr, status, error){
		console.error('AJAX error:', status, error);
		}
	});
	console.log(WMS_PassArray);
	  return WMS_PassArray;
//return Object.keys(WMS_unique).map(function(k) {  return WMS_unique[k]; });
}
//const WMS_PassArray = WMS_Roster_Array();