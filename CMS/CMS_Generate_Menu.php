<input type="checkbox" id="CMS_Nav_Tog" class="CMS_DisNon" aria-hidden="true">
<label class="CMS_Nav_overlay" for="CMS_Nav_Tog" aria-hidden="true"></label>

<nav id="CMS_side_menu" class="CMS_side_menu" aria-label="Main">
	<div class="CMS_Menu_Header">Menu</div>
	<ul class="CMS_Menu_List">
<?PHP 
	$CMS_SQL_Men1 = "SELECT * FROM CMS_menu_links WHERE lang_id = :CMS_lang_id ORDER BY sort ASC";
	$CMS_SQL_Men2 = $SQL_Con->prepare($CMS_SQL_Men1);
	$CMS_SQL_Men2->execute([':CMS_lang_id' => $CMS_GrabLang8]);
	$CMS_SQL_Men3 = $CMS_SQL_Men2->fetchAll(PDO::FETCH_ASSOC); 
	foreach($CMS_SQL_Men3 as $CMS_Ul1){
		if($CMS_Ul1['rights_id'] === 0 || in_array($CMS_Ul1['rights_id'], $_SESSION['CMS_3'])){ 
			$CMS_SQL_Men4 = "SELECT * FROM CMS_Pages WHERE id = :CMS_pages_id";
			$CMS_SQL_Men5 = $SQL_Con->prepare($CMS_SQL_Men4);
			$CMS_SQL_Men5->execute([':CMS_pages_id' => $CMS_Ul1['pages_id']]);
			$CMS_SQL_Men6 = $CMS_SQL_Men5->fetch(); ?>
		<li class="<?PHP echo $CMS_Ul1['style']; ?>"><a href="<?PHP if(isset($CMS_SQL_Men6['Lang_Tx'])){ echo "./" . $CMS_SQL_Men6['Lang_Tx'] . "/"; } echo $CMS_SQL_Men6['page_name'] . $CMS_SQL_Men6['page_ext']; ?>"><?PHP echo $CMS_Ul1['label']; ?></a></li>
		<?PHP }
	} ?>
	</ul>
</nav>