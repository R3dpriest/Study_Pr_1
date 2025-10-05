<header class="CMS_Top" role="banner">
    <div class="CMS_DisFlex">
		<div class="CMS_DisFlex CMS_JuCen CMS_AlCen CMS_DisBox">
			<?PHP if(isset($_SESSION['CMS_1'])){ echo $_SESSION['CMS_1']; }
			else {?>
				<a class="CMS_But CMS_But_a" href="CMS_login.php">Login</a>
			<?PHP } ?>
		</div>
		<div class="CMS_Brand CMS_DisBox">
			<img src="/Css/Banner.png" class="CMS_Banner" alt="Food Bank Logo" style="cursor: pointer;" onclick="window.location.href='Index.php'">
		</div>
	</div>
	<label class="CMS_Menu_But" for="CMS_Nav_Tog" role="button" aria-controls="side-menu" aria-expanded="false" aria-label="Open menu">
		<span class="CMS_Menu_Line" aria-hidden="true"></span>
	</label>
</header>