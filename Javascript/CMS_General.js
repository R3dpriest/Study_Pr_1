// Global 
let current;

$(document).ready(function () {
	// Check JS
	if($("#JsEna").length){$("#JsEna").hide();}
	
	if($('.CMS_Tab')){ // Tabs
		const $tabs = $('.CMS_Tab');
		const $tabData = $('.CMS_TabData');
		$tabData.hide().first().show().addClass('active');
		$tabs.first().addClass('active');
		$tabs.on('click', function (){
			const index = $tabs.index(this);
			$tabs.removeClass('active');
			$(this).addClass('active');
			$tabData.removeClass('active').hide();
			$tabData.eq(index).addClass('active').show();
		});
	}
	if($('#CMS_Nav_Tog')){ // Menu
		const $CMS_Nav_Tog = $('#CMS_Nav_Tog');
		const $CMS_Menu_But = $('.CMS_Menu_But');
		const $CMS_Nav_sync = () =>{ $CMS_Menu_But.attr('aria-expanded', String($CMS_Nav_Tog.is(':checked'))); };
		$CMS_Nav_Tog.on('change', $CMS_Nav_sync); // checkbox change => trigger sync
		$CMS_Nav_sync();
		$(document).on('keydown', function(e){
			if (e.key === 'Escape' && $CMS_Nav_Tog.is(':checked')) {
				$CMS_Nav_Tog.prop('checked', false);
				CMS_Nav_sync();
			}
		});
	}
});

function CMS_Reload_get(key, value) {
  const url = new URL(window.location.href);
  url.searchParams.set(key, value);
  window.location.href = url.toString();
}