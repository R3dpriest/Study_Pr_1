<?PHP 

include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Template_Filestart.php"; 


if(session_status() !== PHP_SESSION_ACTIVE){session_start();}
global $CMS_ExTrans3;
if(empty($_SESSION['CMS_CHK_TKN'])){$_SESSION['CMS_CHK_TKN'] = bin2hex(random_bytes(32));} ?>
<div class="CMS_TabHead">
	<div class="CMS_Tab">Login</div>
	<div class="CMS_Tab">Create account</div>
</div>
<div class="CMS_TabContent">
	<div class="Tab_Login CMS_TabData">
<?PHP if(isset($_GET['M'])){ echo "<div class='CMS_LG_N CMS_mw_f CMS_DisFlex'>".$_GET['M']."</div>";} ?>
		<h1 id="CMS_Log_title"><?PHP echo $CMS_ExTrans3['CMS_Log_HL1']; ?></h1>
		<form id="loginForm" name="loginForm" method="POST" action="CMS_Login_catch.php?Q=1" target="_SELF">
		<input type="hidden" name="CMS_TOK" value="<?php echo $_SESSION['CMS_CHK_TKN']; ?>">
		<table>
			<thead></thead>
			<tbody>
				<tr>
					<td><label for="Log_username"><?PHP echo $CMS_ExTrans3['CMS_Log_USR']; ?></label></td>
					<td><input id="CMS_Log_username" name="Log_username" type="text" inputmode="text" autocomplete="username" required placeholder="<?PHP echo $CMS_ExTrans3['CMS_Log_USR']; ?>..."/></td>
				</tr>
				<tr>
					<td><label for="Log_password"><?PHP echo $CMS_ExTrans3['CMS_Log_PSW']; ?></label></td>
					<td><input id="CMS_password1" name="Log_password" type="password" autocomplete="current-password" required minlength="8" maxlength="20" aria-invalid="false" placeholder="••••••••" /></td>
				</tr>
				<tr>
					<td><label for="log_stay"><?PHP echo $CMS_ExTrans3['CMS_Log_STA']; ?></label></td>
					<td><input type="checkbox" name="Log_stay"></td>
				</tr>
				<tr>
					<td><button type="submit" class="CMS_But"><?PHP echo $CMS_ExTrans3['CMS_Log_BT1']; ?></button></td>
				</tr>
			</tbody>
		</table>
		</form>
		<div class="CMS_Log_Lane">
			<a href="#" class="CMS_Log_sub" disabled>Forgot password? [not implemented]</a></small>
		</div>
	</div>
	<div id="Tab_Create" class="CMS_TabData">
		<main class="CMS_Log_Layout" role="main" aria-labelledby="title">
		<h1 id="CMS_Log_title"><?PHP echo $CMS_ExTrans3['CMS_Log_HL2']; ?></h1>
		<p class="sub"><?PHP echo $CMS_ExTrans3['CMS_Log_EXT']; ?></p>
		<p id="JsEna">Javascript seems disabled. This means that certain scripts are disabled.</p>
		<form id="CreateForm" name="CreateForm" method="POST" action="CMS_Login_catch.php?Q=2" target="_SELF">
		<input type="hidden" name="CMS_TOK" value="<?php echo $_SESSION['CMS_CHK_TKN']; ?>">
		<table>
			<thead></thead>
			<tbody>
				<tr>
					<td><label for="username"><?PHP echo $CMS_ExTrans3['CMS_Log_USR']; ?></label></td>
					<td><input id="CMS_username" name="username" type="text" inputmode="text" autocomplete="username" required placeholder="Username..."/></td>
					<td id="CMS_username_Error" class="CMS_Error"></td>
				</tr>
				<tr>
					<td><label for="email"><?PHP echo $CMS_ExTrans3['CMS_Log_EMA']; ?></label></td>
					<td><input id="CMS_email" name="email" type="email" autocomplete="email" required aria-invalid="false" placeholder="name@example.com" /></td>
					<td id="CMS_email_Error" class="CMS_Error"></td>
				</tr>
				<tr>
					<td><label for="password1"><?PHP echo $CMS_ExTrans3['CMS_Log_PSW']; ?></label></td>
					<td><input id="CMS_password1" name="password1" type="password" required minlength="8" maxlength="20" placeholder="••••••••" /></td>
					<td id="CMS_password1_Error" class="CMS_Error"></td>
				</tr>
				<tr>
					<td><label for="password2"><?PHP echo $CMS_ExTrans3['CMS_Log_PSW']; ?></label></td>
					<td><input id="CMS_password2" name="password2" type="password" required minlength="8" maxlength="20" placeholder="••••••••" /></td>
					<td id="CMS_password2_Error" class="CMS_Error"></td>
				</tr>
				<tr>
					<td><button class="CMS_Log_send CMS_But" type="submit" id="CMS_Log_But"><?PHP echo $CMS_ExTrans3['CMS_Log_BT1']; ?></button></td>
				<tr>
			</tbody>
		</table>
		<div id="CMS_formMessage" class="form-message" aria-live="polite"></div>
		</form>
		</main>
	</div>
</div>
</body>
</html>
