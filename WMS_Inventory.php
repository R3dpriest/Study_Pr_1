<?PHP include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Template_Filestart.php"; 
//WMS_GrabAllLocations("WMS_Location");

if(isset($_GET['L'])){ $Loc_id = $_GET['L']; } else { $Loc_id = $_SESSION['CMS_7']; }
	
//$WMS_SQL_LocData1a = "SELECT wml.id, wml.loc_name, wml.loc_zipcode, wml.loc_city, wml.loc_street, wml.loc_1e_contact_id, wml.loc_2e_contact_id, wml.loc_enabled, pru2.username AS contact_1_user, pru3.username AS contact_2_user, COUNT(prp.donor) AS donor_nr, COUNT(prp.vegetarian) AS vegetarian_nr, COUNT(prp.staff) AS staff_nr, COUNT(prp.client) AS client_nr FROM wms_locations wml LEFT JOIN prof_profiles prp ON prp.loc_id = wml.id LEFT JOIN Prof_Users pru2 ON pru2.id = wml.loc_1e_contact_id LEFT JOIN Prof_Users pru3 ON pru3.id = wml.loc_2e_contact_id LEFT JOIN Prof_Users pru ON prp.users_id = pru.id WHERE wml.id = :loc_id AND pru.enabled = true;";
$WMS_SQL_LocData1a = "SELECT wml.id, wml.loc_name, wml.loc_zipcode, wml.loc_city, wml.loc_street, wml.loc_1e_contact_id, wml.loc_2e_contact_id, wml.loc_enabled, pru2.username AS contact_1_user, pru3.username AS contact_2_user, SUM(CASE WHEN prp.donor = 1 THEN 1 ELSE 0 END) AS donor_nr, SUM(CASE WHEN prp.vegetarian = 1 THEN 1 ELSE 0 END) AS vegetarian_nr, SUM(CASE WHEN prp.staff = 1 THEN 1 ELSE 0 END) AS staff_nr, SUM(CASE WHEN prp.client = 1 THEN 1 ELSE 0 END) AS client_nr FROM wms_locations wml LEFT JOIN prof_profiles prp ON prp.loc_id = wml.id LEFT JOIN Prof_Users pru2 ON pru2.id = wml.loc_1e_contact_id LEFT JOIN Prof_Users pru3 ON pru3.id = wml.loc_2e_contact_id LEFT JOIN Prof_Users pru ON prp.users_id = pru.id WHERE wml.id = :loc_id GROUP BY wml.id, wml.loc_name, wml.loc_zipcode, wml.loc_city, wml.loc_street, wml.loc_1e_contact_id, wml.loc_2e_contact_id, wml.loc_enabled, pru2.username, pru3.username;";
$WMS_SQL_Locdata1b = $GLOBALS['SQL_Con']->prepare($WMS_SQL_LocData1a);
$WMS_SQL_Locdata1b->execute(['loc_id' => $Loc_id]);
$WMS_SQL_Locdata1c = $WMS_SQL_Locdata1b->fetch(PDO::FETCH_ASSOC);


echo "<Script> const Param = new URLSearchParams(window.location.search);
const URLParse = new URLSearchParams(window.location.search);
const URLParse_L = URLParse.get('L');
if(URLParse_L !== null && URLParse_L !== ''){ window.loc_id = URLParse_L; } else { window.loc_id = ".$_SESSION['CMS_7']."; }</script>";
echo '<script src="Javascript/WMS_General.js" defer></script>';
?>
<div class="WMS_Tile_container">
	<div class="WMS_Tile_Content"><h2>Location: <?php echo $WMS_SQL_Locdata1c['loc_name']; ?></h2></div>
	<div class="CMS_DisFlex">
		<div class="WMS_Tile_Content CMS_DisBox CMS_FlNstr"><h2>Location</h2>
		<?PHP WMS_GrabAllLocations('WMS_Ros_loc'); echo $GLOBALS['Gxe']; ?></div>
		<div class="WMS_Tile_Content CMS_DisBox">
			<h2>General information</h2>
			<div class="WMS_G_I_Container">
				<div class="">
					<div class="WMS_G_I_Row">
						<div id="" class=""><?php echo $CMS_ExTrans3['WMS_inv_sta_13']; ?></div>
						<div><?php echo $WMS_SQL_Locdata1c['loc_name']; ?></div>
					</div>
					<div class="WMS_G_I_Row">
						<div id="" class=""><?php echo $CMS_ExTrans3['WMS_inv_sta_10']; ?></div>
						<div><?php echo $WMS_SQL_Locdata1c['loc_city']; ?></div>
					</div>
					<div class="WMS_G_I_Row">
						<div id="" class=""><?php echo $CMS_ExTrans3['WMS_inv_sta_11']; ?></div>
						<div><?php echo $WMS_SQL_Locdata1c['loc_street']; ?></div>
					</div>
					<div class="WMS_G_I_Row">
						<div id="" class=""><?php echo $CMS_ExTrans3['WMS_inv_sta_12']; ?></div>
						<div><?php echo $WMS_SQL_Locdata1c['loc_zipcode']; ?></div>
					</div>
				</div>
				<div class="">
					<div class="WMS_G_I_Row">
						<div id="" class=""><?php echo $CMS_ExTrans3['WMS_inv_sta_1']; ?></div>
						<div><?php echo $WMS_SQL_Locdata1c['staff_nr']; ?></div>
					</div>
					<div class="WMS_G_I_Row">
						<div id="" class=""><?php echo $CMS_ExTrans3['WMS_inv_sta_2']; ?></div>
						<div><?php echo $WMS_SQL_Locdata1c['client_nr']; ?></div>
					</div>
					<div class="WMS_G_I_Row">
						<div id="" class=""><?php echo $CMS_ExTrans3['WMS_inv_sta_3']; ?></div>
						<div><?php echo $WMS_SQL_Locdata1c['vegetarian_nr']; ?></div>
					</div>
					<div class="WMS_G_I_Row">
						<div id="" class=""><?php echo $CMS_ExTrans3['WMS_inv_sta_7']; ?></div>
						<div><?php echo $WMS_SQL_Locdata1c['donor_nr']; ?></div>
					</div>
				</div>
				<div class="">
					<div class="WMS_G_I_Row">
						<div id="" class=" "><?php echo $CMS_ExTrans3['WMS_inv_sta_8']; ?></div>
						<div><a href="CMS_Profile.php?u=<?php echo $WMS_SQL_Locdata1c['loc_1e_contact_id']; ?>"><?php echo $WMS_SQL_Locdata1c['contact_1_user']; ?></a></div>
					</div>
					<div class="WMS_G_I_Row">
						<div id="" class=" "><?php echo $CMS_ExTrans3['WMS_inv_sta_9']; ?></div>
						<div><a href="CMS_Profile.php?u=<?php echo $WMS_SQL_Locdata1c['loc_2e_contact_id']; ?>"><?php echo $WMS_SQL_Locdata1c['contact_2_user']; ?></a></div>
					</div>
				</div>
			</div>
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
include_once __dir__ . "CMS_Footer.php"; ?>