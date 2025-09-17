<?PHP

include_once __dir__ ".\CMS_Content_menu.php";
switch($_GET['Pa']){
	case "1":
	CMS_GrabAllForms('NULL'); ?>
	<div class="">
		<?PHP echo $GAF; ?>
	</div>
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
	<div>
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
				<div class="CMS_EDI_Sub">
					<!-- Jquery / Ajax load content --!>
				</div>
				
			</div>
		</div>
	</div>
	<?PHP 
	break;
	case "2":
	CMS_GrabAllForm_Fields('NULL'); ?>
	<div class="">
		<?PHP echo $GEF; ?>
	</div>
	<div class="CMS_La_M">
		<div class="CMS_La_S">
			<div id="CMS_EDI_L1">ID</div>
			<div id="CMS_EDI_E1"></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L2">form ID</div>
			<div id=""><input type="numer" id="CMS_EDI_E2"></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L3">field name</div>
			<div id=""><input type="text" id="CMS_EDI_E3"></div>
		</div>
		<div class="CMS_La_S">
			<div id="CMS_EDI_L4">field type</div>
			<div id=""><select id="CMS_EDI_E4"><option value="0">text</option><option value="1">textarea</option><option value="2">email</option><option value="3">checkbox</option><option value="4">radio</option><option value="5">button</option><option value="6">number</option></select></div>
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
			<div id=""><select id="CMS_EDI_E7"><option value="true">true</div><div value="false">false</option></select></div>
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
	<div>
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
				<div class="CMS_EDI_Sub">
					<!-- Jquery / Ajax load content --!>
				</div>
				
			</div>
		</div>
	</div>
	
	<?PHP
}
	?>