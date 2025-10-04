<header class="CMS_Top" role="banner">
    <div class="CMS_Log">
		<?PHP if(!isset($_SESSION['CMS_1'])){ echo $_SESSION['CMS_1']; }
		else {?>
			<button href="./CMS/CMS_login.htlm">Login</button>
		<?PHP } ?>
	</div>
	<div class="CMS_Brand">
		<img href="./CMS/Banner.png" class="CMS_Banner" href="<?PHP echo $CMS_GetLang3; ?>\Index.php">
	</div>
	<label class="CMS_Menu_But" for="CMS_Nav_Tog" role="button" aria-controls="side-menu" aria-expanded="false" aria-label="Open menu">
		<span class="CMS_Menu_Line" aria-hidden="true"></span>
	</label>
</header>