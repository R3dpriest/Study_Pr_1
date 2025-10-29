<?PHP
include_once __dir__ . DIRECTORY_SEPARATOR . "CMS_Template_Filestart.php"; 

if(session_status() !== PHP_SESSION_ACTIVE){session_start();}
include_once __dir__ . DIRECTORY_SEPARATOR . "Function_lib" . DIRECTORY_SEPARATOR . "CMS_Populate_Cal.php"; 
$Pa = $_GET['Q'];
if(empty($_SESSION['CMS_CHK_TKN'])){$_SESSION['CMS_CHK_TKN'] = bin2hex(random_bytes(32));} ?>
<input type="hidden" id="CMS_EDI_E0" value="<?PHP echo $_SESSION['CMS_CHK_TKN']; ?>">

<?PHP
switch($Pa){
	case "1": // forms
	CMS_GrabAllForms('CMS_Form_field_1'); ?>
	<div class=" CMS_p_5 CMS_m_20 CMS_URPR_Window">
		<div class=""></div>
		<div class="CMS_La_M">
			<div class="CMS_Prof_I CMS_DisFlex CMS_DisBox">
				<div id="CMS_EDI_L6" class="CMS_W_200 CMS_S_MW_195"><?php echo $GAF; ?></div>
				<div><button class="CMS_But" type="submit" id="CMS_EDI_ES1">update</button></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L1" class="CMS_W_200">ID</div>
				<div id="CMS_EDI_E1"></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L2" class="CMS_W_200">Name</div>
				<div id=""><input type="text" id="CMS_EDI_E2"></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L3" class="CMS_W_200">Description</div>
				<div id=""><input type="text" id="CMS_EDI_E3"></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L4" class="CMS_W_200">Target</div>
				<div id=""><input type="text" id="CMS_EDI_E4"></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L5" class="CMS_W_200">Creation</div>
				<div id="CMS_EDI_E5"></div>
			</div>
		</div>
		<div class="CMS_DisNon" id="CMS_EDI_Tog">
			<div class="CMS_TabHead">
				<div class="CMS_Tab">Current</div>
				<div class="CMS_Tab">Create new</div>
			</div>
			<div class="CMS_TabContent">
				<div class="CMS_TabData">
					<div class="CMS_Prof_I CMS_DisFlex">
						<div class="CMS_W_200 CMS_S_MW_195"><select id="CMS_EDI_SUB_SEL" class="CMS_EDI_Q_1"></select></div><div><button id="CMS_EDI_Refresh" class="CMS_But">Refresh</button><button id="CMS_EDI_Update1" class="CMS_But">Update</button></div>
					</div>
					<form action="CMS_EDI_forms_catch.php" method="POST">
					<input type="hidden" name="CMS_TOK" value="<?php echo $_SESSION['CMS_CHK_TKN']; ?>">
					<div class="CMS_Prof_I CMS_DisFlex" placeholder="Unique handle in the database">
						<div class="CMS_W_200">ID</div><div id="CMS_SUB_ID"></div>
					</div>
					<div class="CMS_Prof_I CMS_DisFlex" placeholder="Form it is attached to.">
						<div class="CMS_W_200">form id</div><div id="CMS_SUB_FID"></div>
					</div>
					<div class="CMS_Prof_I CMS_DisFlex">
						<div class="CMS_W_200" placeholder="Handle for the <form>">Field named</div><div><input id="CMS_SUB_Key" name="CMS_SUB_Key" type="text" required /></div>
					</div>
					<div class="CMS_Prof_I CMS_DisFlex">
						<div class="CMS_W_200">Type of field</div><div><select id="CMS_SUB_Typ" name="CMS_SUB_Typ"><option value="text">text</option><option value="textarea">textarea</option><option value="email">email</option><option value="checkbox">checkbox</option><option value="radio">radio</option><option value="button">button</option><option value="number">number</option></select></div>
					</div>
					<div class="CMS_Prof_I CMS_DisFlex">
						<div class="CMS_W_200" placeholder="Must be unique, for id='' attribute">Script ID</div><div><input id="CMS_SUB_Ank" name="CMS_SUB_Ank" type="text" required /></div>
					</div>
					<div class="CMS_Prof_I CMS_DisFlex">
						<div class="CMS_W_200" placeholder="Used internally">The description</div><div><input id="CMS_SUB_Dis" name="CMS_SUB_Dis" type="text" required /></div>
					</div>
					<div class="CMS_Prof_I CMS_DisFlex">
						<div class="CMS_W_200" placeholder="True or False">Is this field required?</div><div><select id="CMS_SUB_Req" name="CMS_SUB_Req"><option selected hidden value="99999">Select</option><option value="1">true</option><option value="0">false</option></select></div>
					</div>
					<div class="CMS_Prof_I CMS_DisFlex">
						<div class="CMS_W_200" placeholder="Sort order">The order on of field generation</div><div><input id="CMS_SUB_Ord" name="CMS_SUB_Ord" type="number" required /></div>
					</div>
					<div class="CMS_Prof_I CMS_DisFlex">
						<div class="CMS_W_200"	><input type="hidden" value="" name="CMS_Form_field_6" id="CMS_Form_field_6"><button type="submit">Send</button></div><div></div>
					</div>
					</form>
				</div>
				<div class="CMS_TabData">
					<form action="CMS_EDI_forms_catch.php" method="POST">
					<input type="hidden" name="CMS_TOK" value="<?php echo $_SESSION['CMS_CHK_TKN']; ?>">
					<div class="CMS_New_Cont">
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200">ID</div><div><input type="hidden" id="CMS_Task" name="CMS_Task" value="CMS_Form_fields">To be assigned</div>
						</div>
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200" placeholder="Linked id">form id</div><div id="CMS_EDI_Ank"></div>
						</div>
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200" placeholder="Handle for the <form>">Field name</div><div><input id="CMS_Form_field_" name="CMS_Form_field_7" type="text" required /></div>
						</div>
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200">Type of field</div><div><select id="CMS_Form_field_8" name="CMS_Form_field_8"><option value="text">text</option><option value="textarea">textarea</option><option value="email">email</option><option value="checkbox">checkbox</option><option value="radio">radio</option><option value="button">button</option><option value="number">number</option></select></div>
						</div>
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200" placeholder="Must be unique, for id='' attribute">Script ID</div><div><input id="CMS_Form_field_2" name="CMS_Form_field_2" type="text" required /></div>
						</div>
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200" placeholder="Used internally">The description</div><div><input id="CMS_Form_field_3" name="CMS_Form_field_3" type="text" required /></div>
						</div>
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200" placeholder="True or False">Is this field required?</div><div><select id="CMS_Form_field_4" name="CMS_Form_field_4"><option selected hidden value="99999">Select</option><option value="true">true</option><option value="false">false</option></select></div>
						</div>
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200" placeholder="Sort order">The order on of field generation</div><div><input id="CMS_Form_field_5" name="CMS_Form_field_5" type="number" required /></div>
						</div>
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200"	><input type="hidden" value="" name="CMS_Form_field_6" id="CMS_Form_field_6"><button type="submit">Send</button></div><div></div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php 


	break;
	case "2":
		CMS_GrabAllForm_Fields('CMS_Field_Lang_2');
		?>
		<div class=""></div>
		<div class="CMS_La_M">
			<div class="CMS_Prof_I CMS_DisFlex CMS_DisBox">
				<div id="CMS_EDI_L6" class="CMS_W_200 CMS_S_MW_195"><?php echo $GEF; ?></div>
				<div><button class="CMS_But" type="submit" id="CMS_EDI_ES1">update</button></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L1" class="CMS_W_200">ID</div>
				<div id="CMS_EDI_E1"></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L2" class="CMS_W_200">form ID</div>
				<div id=""><input type="number" id="CMS_EDI_E2"></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L3" class="CMS_W_200">Field name</div>
				<div id=""><input type="text" id="CMS_EDI_E3"></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L4" class="CMS_W_200">Type of field</div>
				<div id=""><select id="CMS_EDI_E4" name="CMS_Form_field_8"><option value="text">text</option><option value="textarea">textarea</option><option value="email">email</option><option value="checkbox">checkbox</option><option value="radio">radio</option><option value="button">button</option><option value="number">number</option></select></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L5" class="CMS_W_200">Script ID</div>
				<div id="CMS_EDI_E5"><input type="text" id="CMS_EDI_E5"></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L7" class="CMS_W_200">required</div>
				<div id=""><select id="CMS_EDI_E7"><option value="1">true</option><option value="0">false</option></select></div>
			</div>
			<div class="CMS_Prof_I CMS_DisFlex">
				<div id="CMS_EDI_L8" class="CMS_W_200">Sort</div>
				<div id=""><input type="number" id="CMS_EDI_E8"></div>
			</div>
		</div>
		<div class="CMS_DisNon" id="CMS_EDI_Tog">
			<div class="CMS_TabHead">
				<div class="CMS_Tab">Current</div>
				<div class="CMS_Tab">Create new</div>
			</div>
			<div class="CMS_TabContent">
				<div class="CMS_TabData">
					<div class="CMS_La_M">
						<div class="CMS_Prof_I CMS_DisFlex">
							<div class="CMS_W_200 CMS_S_MW_195"><?PHP CMS_Grab_Lang('CMS_EDI_Lang_sub'); echo $GLOBALS['GxZ']; ?></div><div><button id="CMS_EDI_Refresh_1" class="CMS_But">Refresh</button><button id="CMS_EDI_Update!" class="CMS_But">Update</button></div>
						</div>
						<input type="hidden" name="CMS_TOK" value="<?php echo $_SESSION['CMS_CHK_TKN']; CMS_GrabAllForm_Fields('CMS_EDI_F2'); ?>">
						<div class="CMS_New_Cont">
							<div class="CMS_Prof_I CMS_DisFlex">
								<div class="CMS_W_200">ID</div><div id="CMS_EDI_F1"></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div class="CMS_W_200">field link</div><div><?PHP echo $GLOBALS['GEF']; ?></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div class="CMS_W_200">Language</div><div><?PHP CMS_Grab_Lang('CMS_EDI_F3'); echo $GLOBALS['GxZ']; ?></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div placeholder="Text next to field" class="CMS_W_200">Language Label</div><div><input id="CMS_EDI_F4" name="CMS_Field_Lang_2" type="text" required /></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div placeholder="Hover over" class="CMS_W_200">Hover description</div><div><input id="CMS_EDI_F5" name="CMS_Field_Lang_3" type="text" required /></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div placeholder="Inside <button>Text</button>" class="CMS_W_200">Text inside button</div><div><input id="CMS_EDI_F6" name="CMS_Field_Lang_4" type="text" required /></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div><input type="hidden" value="" name="CMS_Field_Lang_5" id="CMS_Field_Lang_5"><button type="submit">Send</button></div><div></div>
							</div>
						</div>
					</div>
				</div>
				<div class="CMS_TabData">
					<form action="CMS_EDI_forms_catch.php" method="POST">
						<input type="hidden" name="CMS_TOK" value="<?php echo $_SESSION['CMS_CHK_TKN']; ?>">
						<div class="CMS_New_Cont">
							<div class="CMS_Prof_I CMS_DisFlex">
								<div class="CMS_W_200">ID</div><div><input type="hidden" id="CMS_Task" name="CMS_Task" value="CMS_Form_field_translation">To be assigned</div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div class="CMS_W_200">field link</div><div id="CMS_EDI_Ank"></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div class="CMS_W_200">Language</div><div><?PHP CMS_Grab_Lang('CMS_EDI_Lang_sub_new'); echo $GLOBALS['GxZ']; ?></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div placeholder="Text next to field" class="CMS_W_200">Language Label</div><div><input id="CMS_Field_Lang_2" name="CMS_Field_Lang_2" type="text" required /></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div placeholder="Hover over" class="CMS_W_200">Hover description</div><div><input id="CMS_Field_Lang_3" name="CMS_Field_Lang_3" type="text" required /></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div placeholder="Inside <button>Text</button>" class="CMS_W_200">Text inside button</div><div><input id="CMS_Field_Lang_4" name="CMS_Field_Lang_4" type="text" required /></div>
							</div>
							<div class="CMS_Prof_I CMS_DisFlex">
								<div><input type="hidden" value="" name="CMS_Field_Lang_5" id="CMS_Field_Lang_5"><button type="submit">Send</button></div><div></div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
	break;
	case "3":
	CMS_GrabAllpages('CMS_Page_Add_1'); CMS_Grab_Lang('CMS_EDI_Y4'); CMS_Rights_Labels('CMS_EDI_Y6');?>
	<div class=""><?php echo $GLOBALS['GZF']; ?></div>
	<div class="CMS_La_M">
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L1" class="CMS_W_200">ID</div><div id="CMS_EDI_Y1"></div>
		</div>
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L2" class="CMS_W_200">Page Name</div><div id=""><input type="text" name="CMS_EDI_Y2" id="CMS_EDI_Y2"/></div>
		</div>
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L3" class="CMS_W_200">Extention</div><div id=""><input type="text" id="CMS_EDI_Y3"/></div>
		</div>
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L4" class="CMS_W_200">Language</div><div id=""><?php echo $GxZ; ?></div>
		</div>
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L5" class="CMS_W_200">Language Tag</div><div id=""><input type="text" id="CMS_EDI_Y5" name="CMS_EDI_Y5" placeholder="Example 'EN'"/></div>
		</div>
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L6" class="CMS_W_200">Reading Rights</div><div id=""><?php echo $GLOBALS['GxQ']; ?></div>
		</div>
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L7" class="CMS_W_200">Writing Rights</div><div id=""><?php  CMS_Rights_Labels('CMS_EDI_Y7'); echo $GLOBALS['GxQ']; ?></div>
		</div>
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L8" class="CMS_W_200">Page header</div><div id="CMS_EDI_E8"><input type="text" id="CMS_EDI_Y8" name="CMS_EDI_Y8" placeholder="Header of the page"/></div>
		</div>
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L9" class="CMS_W_200">Page load option</div><div id="CMS_EDI_E9"><select id="CMS_EDI_Y9" name="CMS_EDI_Y9"><option value="process">process</option><option value="write">write</option><option value="read">read</option></select></div>
		</div>
		<div class="CMS_Prof_I CMS_DisFlex">
			<div id="CMS_EDI_L10" class="CMS_W_200"></div>
			<div><button type="submit" id="CMS_EDI_ES3">update</button></div>
		</div>
	</div>
	<div class="CMS_TabHead">
		<div class="CMS_Tab">Current</div>
		<div class="CMS_Tab">Sub Elements</div>
	</div>
	<div class="CMS_TabContent">
		<div class="CMS_TabData">
			<div class="CMS_La_M">
				<div class="CMS_Prof_I CMS_DisFlex">
					<div><button id="CMS_EDI_Refresh">Refresh</button></div>
				</div>
				<div>
					<ul class="CMS_EDI_DateTab CMS_Sort">
						<li><div><div>Form_1</div><div>Created</div></div></li>
						<li>test</li>
						<li>test</li>
						<li>test</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="CMS_TabData">
			<h2>Welcome</h2>
			We have currently implemented three different sub elements.
			<ol>
				<li>The <a href="CMS_EDI_For.php?Q=1">forms</a> - These are fields that can submit data.</li>
				<li>The <a href="CMS_EDI_For.php?Q=4">raw text</a> - These are good to deposite large ammounts of text. These cleanse any and all programming code and just deposit raw text.</li>
				<li>The <a href="CMS_EDI_For.php?Q=5">codet</a> - These are good to deposite text and code. Be warned, it allows for any code. Even those that can destroy your database.</li>
			</ol>
		</div>
	</div>	
<?php
break;
}
?>
<script src="../Javascript/CMS_EDI_Cms.js" defer></script>