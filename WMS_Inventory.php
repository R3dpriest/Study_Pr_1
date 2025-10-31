<<<<<<< HEAD
<?PHP include_once __dir__ . "CMS_Header.php"; 
GrabAllLocations("WMS_Location");

?>
<div class="WMS_Tile_container">
	<div class="WMS_Tile_Content"><h2>Location<h2></div>
	<div class="CMS_DisFlex">
		<div class="WMS_Tile_Content CMS_DisBox CMS_FlNstr"><h2>Location<h2>
		<?PHP echo $Gxe;  ?></div>
		<div class="WMS_Tile_Content CMS_DisBox">
			<h2>General information<h2>
			<table class="WMS_Ing_list" id="WMS_INV_Xdata"></table>
		</div>
	</div>
	<div class="WMS_Tile_Content">
		<h2>Inventory</h2>
		<div class="WMS_Table_Container">
			<table class="WMS_Ing_list"`id="WMS_INV_inventory"></table>
		</div>
	</div>
	<div class="CMS_DisFlex">
		<div class="WMS_Tile_Content CMS_DisBox CMS_FlNstr">
		<select id="WMS_INV_OPT_SEL"><option value="0">Donations</option><option value="1">Processed</option><option value="2">Transferred</option></select>
		<button class="CMS_But">Audit</button>
		</div>
		<div class="WMS_Tile_Content CMS_DisBox">
			<h2 id="WMS_INV_h2"><h2>
			<table class="WMS_Ing_list" id="WMS_INV_tab"></table>
		</div>
	</div>
</div>







<? PHP
=======
<?PHP include_once __dir__ . "CMS_Header.php"; 
GrabAllLocations("WMS_Location");

?>
<div class="WMS_Tile_container">
	<div class="WMS_Tile_Content"><h2>Location<h2></div>
	<div class="CMS_DisFlex">
		<div class="WMS_Tile_Content CMS_DisBox CMS_FlNstr"><h2>Location<h2>
		<?PHP echo $Gxe;  ?></div>
		<div class="WMS_Tile_Content CMS_DisBox">
			<h2>General information<h2>
			<table class="WMS_Ing_list" id="WMS_INV_Xdata"></table>
		</div>
	</div>
	<div class="WMS_Tile_Content">
		<h2>Inventory</h2>
		<div class="WMS_Table_Container">
			<table class="WMS_Ing_list"`id="WMS_INV_inventory"></table>
		</div>
	</div>
	<div class="CMS_DisFlex">
		<div class="WMS_Tile_Content CMS_DisBox CMS_FlNstr">
		<select id="WMS_INV_OPT_SEL"><option value="0">Donations</option><option value="1">Processed</option><option value="2">Transferred</option></select>
		<button class="CMS_But">Audit</button>
		</div>
		<div class="WMS_Tile_Content CMS_DisBox">
			<h2 id="WMS_INV_h2"><h2>
			<table class="WMS_Ing_list" id="WMS_INV_tab"></table>
		</div>
	</div>
</div>







<? PHP
>>>>>>> 236a705ea03f897fdff7b98c7f9240fd984e414b
include_once __dir__ . "CMS_Footer.php"; ?>