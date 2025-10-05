<?PHP
include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Template_Filestart.php"; 

if(session_status() !== PHP_SESSION_ACTIVE){session_start();}

$Pa = $_GET['Pa'];
if(empty($_SESSION['CMS_CHK_TKN'])){$_SESSION['CMS_CHK_TKN'] = bin2hex(random_bytes(32));}

switch($Pa){
	case "1": // forms
	CMS_GrabAllForms('CMS_Form_field_1'); ?>
	<div class=""><?php echo htmlspecialchars($GAF ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
	<div class="CMS_La_M">
		<div class="CMS_La_S">
			<div id="CMS_EDI_L1">ID</div>
			<div id="CMS_EDI_E1"></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L2">Name</div>
			<div id=""><input type="text" id="CMS_EDI_E2"></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L3">Description</div>
			<div id=""><input type="text" id="CMS_EDI_E3"></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L4">Target</div>
			<div id=""><input type="text" id="CMS_EDI_E4"></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L5">Creation</div>
			<div id="CMS_EDI_E5"></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L6"></div>
			<div><button type="submit" id="CMS_EDI_ES1">update</button></div>
		</div>
	</div>

	<div class="CMS_TabHead">
		<div class="CMS_Tab">Current</div>
		<div class="CMS_Tab">Create new</div>
	</div>
	<div class="CMS_TabContent">
		<div class="CMS_La_M">
			<div class="CMS_La_S">
			<div><button id="CMS_EDI_Refresh">Refresh</button></div>
			<div><button class="CMS_EDI_Ite">Button</button></div>
			</div>
			<div class="CMS_EDI_Sub"></div>
		</div>
	</div>
	<div class="CMS_TabContent">
		<form action="CMS_EDI_forms_catch.php" method="POST">
		<input type="hidden" name="CMS_TOK" value="<?php echo $_SESSION['CMS_CHK_TKN']; ?>">
		<div class="CMS_New_Cont">
			<div>
				<div>ID</div><div><input type="hidden" id="CMS_Task" name="CMS_Task" value="CMS_Form_fields">To be assigned</div>
			</div>
			<div>
				<div placeholder="Linked id">form id</div><div id="CMS_EDI_Ank"></div>
			</div>
			<div>
				<div placeholder="Handle for the <form>">Name field</div><div><input id="CMS_Form_field_" name="CMS_Form_field_7" type="text" required /></div>
			</div>
			<div>
				<div>Type of field</div><div><select id="CMS_Form_field_8" name="CMS_Form_field_8"><option value="text">text</option><option value="textarea">textarea</option><option value="email">email</option><option value="checkbox">checkbox</option><option value="radio">radio</option><option value="button">button</option><option value="number">number</option></select></div>
			</div>
			<div>
				<div placeholder="Must be unique, for id='' attribute">Script ID</div><div><input id="CMS_Form_field_2" name="CMS_Form_field_2" type="text" required /></div>
			</div>
			<div>
				<div placeholder="Used internally">The description</div><div><input id="CMS_Form_field_3" name="CMS_Form_field_3" type="text" required /></div>
			</div>
			<div>
				<div placeholder="True or False">Is this field required?</div><div><select id="CMS_Form_field_4" name="CMS_Form_field_4"><option value="true">true</option><option value="false">false</option></select></div>
			</div>
			<div>
				<div placeholder="Sort order">The order on of field generation</div><div><input id="CMS_Form_field_5" name="CMS_Form_field_5" type="text" required /></div>
			</div>
			<div>
				<div><input type="hidden" value="" name="CMS_Form_field_6" id="CMS_Form_field_6"><button type="submit">Send</button></div><div></div>
			</div>
		</div>
		</form>
	</div>
<?php 
	break;
	case "2":
		CMS_GrabAllForm_Fields('CMS_Field_Lang_1');
		?>
		<div class=""><?php echo htmlspecialchars($GEF ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
		<div class="CMS_La_M">
			<div class="CMS_La_S">
				<div id="CMS_EDI_L1">ID</div>
				<div id="CMS_EDI_E1"></div>
			</div>
			<div class="CMS_La_S">
				<div id="CMS_EDI_L2">form ID</div>
				<div id=""><?php CMS_GrabAllForms('CMS_EDI_E2'); echo htmlspecialchars($GAF ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
			</div>
			<div class="CMS_La_S">
				<div id="CMS_EDI_L3">field name</div>
				<div id=""><input type="text" id="CMS_EDI_E3"></div>
			</div>
			<div class="CMS_La_S">
				<div id="CMS_EDI_L4">field type</div>
				<div id=""><select id="CMS_EDI_E4"><option value="text">text</option><option value="textarea">textarea</option><option value="email">email</option><option value="checkbox">checkbox</option><option value="radio">radio</option><option value="button">button</option><option value="number">number</option></select></div>
			</div>
			<div class="CMS_La_S">
				<div id="CMS_EDI_L5">field unique id</div>
				<div id=""><input type="text" id="CMS_EDI_E5"></div>
			</div>
			<div class="CMS_La_S">
				<div id="CMS_EDI_L6">field description</div>
				<div id=""><input type="text" id="CMS_EDI_E6"></div>
			</div>
			<div class="CMS_La_S">
				<div id="CMS_EDI_L7">required</div>
				<div id=""><select id="CMS_EDI_E7"><option value="true">true</option><option value="false">false</option></select></div>
			</div>
			<div class="CMS_La_S">
				<div id="CMS_EDI_L8">Sort</div>
				<div id=""><input type="number" id="CMS_EDI_E8"></div>
			</div>
			<div class="CMS_La_S">
				<div id="CMS_EDI_L9"></div>
				<div><button type="submit" id="CMS_EDI_ES2">update</button></div>
			</div>
		</div>
		<div class="CMS_TabHead">
			<div class="CMS_Tab">Current</div>
			<div class="CMS_Tab">Create new</div>
		</div>
		<div class="CMS_TabContent">
			<div class="CMS_La_M">
				<div class="CMS_La_S">
					<div><button id="CMS_EDI_Refresh">Refresh</button></div>
					<div><button class="CMS_EDI_Ite">Button</button></div>
				</div>
				<div class="CMS_EDI_Sub"></div>
			</div>
		</div>
		<div class="CMS_TabContent">
			<form action="CMS_EDI_forms_catch.php" method="POST">
				<input type="hidden" name="CMS_TOK" value="<?php echo $_SESSION['CMS_CHK_TKN']; ?>">
				<div class="CMS_New_Cont">
					<div>
						<div>ID</div><div><input type="hidden" id="CMS_Task" name="CMS_Task" value="CMS_Form_field_translation">To be assigned</div>
					</div>
					<div>
						<div>field link</div><div id="CMS_EDI_Ank"></div>
					</div>
					<div>
						<div>Language</div><div><?php echo htmlspecialchars($GxZ ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
					</div>
					<div>
						<div placeholder="Text next to field">Label</div><div><input id="CMS_Field_Lang_2" name="CMS_Field_Lang_2" type="text" required /></div>
					</div>
					<div>
						<div placeholder="Hover over">Hover description</div><div><input id="CMS_Field_Lang_3" name="CMS_Field_Lang_3" type="text" required /></div>
					</div>
					<div>
						<div placeholder="Inside <button>Text</button>">Text inside button</div><div><input id="CMS_Field_Lang_4" name="CMS_Field_Lang_4" type="text" required /></div>
					</div>
					<div>
						<div><input type="hidden" value="" name="CMS_Field_Lang_5" id="CMS_Field_Lang_5"><button type="submit">Send</button></div><div></div>
					</div>
				</div>
			</form>
		</div>
		<?php
	break;
	case "3":
	CMS_GrabAllpages('CMS_Page_Add_1'); CMS_Grab_Lang('CMS_EDI_E4'); CMS_Rights_Labels('CMS_Page_Add_4'); ?>
	<div class=""><?php echo htmlspecialchars($GZF ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
	<div class="CMS_La_M">
		<div class="CMS_La_S">
			<div id="CMS_EDI_L1">ID</div>
			<div id="CMS_EDI_E1"></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L2">Page Name</div>
			<div id=""><input type="text" name="CMS_EDI_E2" id="CMS_EDI_E2"/></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L3">Extention</div>
			<div id=""><input type="text" id="CMS_EDI_E3"/></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L4">Language</div>
			<div id=""><?php echo htmlspecialchars($GxZ ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L5">Language Tag</div>
			<div id="CMS_EDI_E5"><input type="text" id="CMS_EDI_E5" name="CMS_EDI_E5" placeholder="Example 'EN'"/></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L6">Reading Rights</div>
			<div id="CMS_EDI_E6"><?php echo htmlspecialchars($GsQ ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L7">Writing Rights</div>
			<div id="CMS_EDI_E7"><?php echo htmlspecialchars($GsQ ?? '', ENT_QUOTES, 'UTF-8'); ?></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L8">Page header</div>
			<div id="CMS_EDI_E8"><input type="text" id="CMS_EDI_E8" name="CMS_EDI_E8" placeholder="Header of the page"/></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L9">Page load option</div>
			<div id="CMS_EDI_E9"><select id="CMS_EDI_E9" name="CMS_EDI_E9"><option value="process">process</option><option value="write">write</option><option value="read">read</option></select></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L10"></div>
			<div><button type="submit" id="CMS_EDI_ES3">update</button></div>
		</div>
	</div>
	<div class="CMS_TabHead">
		<div class="CMS_Tab">Current</div>
		<div class="CMS_Tab">Create new</div>
	</div>
	<div class="CMS_TabContent">
		<div class="CMS_La_M">
			<div class="CMS_La_S">
				<div><button id="CMS_EDI_Refresh">Refresh</button></div>
				<div><button class="CMS_EDI_Ite">Button</button></div>
			</div>
			<div class="CMS_EDI_Sub"></div>
		</div>
	</div>
	<div class="CMS_TabContent">
	<form action="CMS_Page_content.php" method="POST">
	<input type="hidden" name="CMS_TOK" value="<?php echo $_SESSION['CMS_CHK_TKN']; ?>">
	<div class="CMS_New_Cont">
		<div>
			<div>ID</div>
			<div><input type="hidden" id="CMS_Task" name="CMS_Task" value="CMS_Form_fields">To be assigned</div>
		</div>
		<div>
			<div placeholder="Linked id">form id</div>
			<div id="CMS_EDI_Ank"></div>
		</div>
		<div>
			<div placeholder="Handle for the <form>">Name field</div>
			<div><input id="CMS_Form_field_" name="CMS_Form_field_7" type="text" required /></div>
		</div>
		<div>
			<div>Type of field</div>
			<div><select id="CMS_Form_field_8" name="CMS_Form_field_8"><option value="text">text</option><option value="textarea">textarea</option><option value="email">email</option><option value="checkbox">checkbox</option><option value="radio">radio</option><option value="button">button</option><option value="number">number</option></select></div>
		</div>
		<div>
			<div placeholder="Must be unique, for id='' attribute">Script ID</div>
			<div><input id="CMS_Form_field_2" name="CMS_Form_field_2" type="text" required /></div>
		</div>
		<div>
			<div placeholder="Used internally">The description</div>
			<div><input id="CMS_Form_field_3" name="CMS_Form_field_3" type="text" required /></div>
		</div>
		<div>
			<div placeholder="True or False">Is this field required?</div>
			<div><select id="CMS_Form_field_4" name="CMS_Form_field_4"><option value="true">true</option><option value="false">false</option></select></div>
		</div>
		<div>
			<div placeholder="Sort order">The order on of field generation</div>
			<div><input id="CMS_Form_field_5" name="CMS_Form_field_5" type="text" required /></div>
		</div>
		<div>
			<div><input type="hidden" value="" name="CMS_Form_field_6" id="CMS_Form_field_6"><button type="submit">Send</button></div><div></div>
		</div>
	</div>
	</form>
	</div>
<?php
break;
}
?>