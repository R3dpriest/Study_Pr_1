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
			<table class="WMS_Ing_list">
		</div>
	</div>
	<div class="WMS_Tile_Content">
		<h2>Inventory</h2>
		<div class="WMS_Table_Container">
			<table class="WMS_Ing_list">
			</table>
		</div>
	</div>
	<div class="CMS_DisFlex">
		<div class="WMS_Tile_Content CMS_DisBox CMS_FlNstr">
		<select><option>Donations</option><option>Processed</option><option>Transferred</option></select>
		<button class="CMS_But">Audit</button>
		</div>
		<div class="WMS_Tile_Content CMS_DisBox">
			<table class="WMS_Ing_list">
				
			</table>
		</div>
	</div>
</div>







<? PHP
include_once __dir__ . "CMS_Footer.php"; ?>