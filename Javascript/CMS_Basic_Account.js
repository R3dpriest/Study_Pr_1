$(function(){ 
	// enable button
	const fields=['#CMS_username','#CMS_email','#CMS_password1','#CMS_password2'];
	const $btn=$("#CMS_Log_But").prop("disabled",true);
	$(document).on('input', fields.join(','), function(){
	const hasValue=fields.some(sel => $(sel).val()?.trim().length > 1);
	if(hasValue){
		if($btn.prop('disabled')) $btn.prop('disabled',false);
	}else{
		if(!$btn.prop('disabled')) $btn.prop('disabled',true);
	}
	});
	//check fields
	$(document).on('input', '#CMS_username', function(){ CMS_Username('CMS_username');});
	$(document).on('input', '#CMS_email', function(){ CMS_Email('CMS_email');});
});

$(function(){$(document).on('input keyup paste blur', '#CMS_password1, #CMS_password2', function(){ CMS_password(this.id, $(this)); } ); });

// had to use co-pilot... had to retry a lot of code only to learn about defer.

const CMS_Patterns = { username: /^[A-Za-z]+$/, email: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,  passLength: /^.{8,20}$/, passLower: /[a-z]/, passUpper: /[A-Z]/, passDigit: /\d/, passSpecial: /[!@#$%^&*()_\-+\[\]{};':"\\|,.<>\/?]/,};

function CMS_password(Pass, $el){
	const CMS_Pass_errors = [];
	const $input = $el || $('#' + Pass);
	const Pw = $input.val().trim();                    // always the live value [co-pilot help]
	if (!CMS_Patterns.passLength.test(Pw)) CMS_Pass_errors.push("Password must be 8–20 characters long");
	if (!CMS_Patterns.passLower.test(Pw)) CMS_Pass_errors.push("Password must include at least one lowercase letter");
	if (!CMS_Patterns.passUpper.test(Pw)) CMS_Pass_errors.push("Password must include at least one uppercase letter");
	if (!CMS_Patterns.passDigit.test(Pw)) CMS_Pass_errors.push("Password must include at least one digit");
	if (!CMS_Patterns.passSpecial.test(Pw)) CMS_Pass_errors.push("Password must include at least one special character");
	$('#' + Pass + '_Error').text(CMS_Pass_errors.length ? CMS_Pass_errors.join("\n") : '');
}

function CMS_Email(eEmail){
	$('#'+eEmail+'_Error').text("");
	let IEmail = $('#'+eEmail).val().trim();
	if(IEmail.length === 0){ $('#'+eEmail+'_Error').text('Email is required.');return;}
	if(!CMS_Patterns.email.test(IEmail)){ $('#'+eEmail+'_Error').text('Enter a valid email like name@example.com.');}
}
function CMS_Username(Usr){
	$('#'+Usr+'_Error').text = "";
	let User = $('#'+Usr).val();
	let UserCl = User.replace(/[^A-Za-z]/g, '');
	if(UserCl !== User){$('#'+Usr).val(UserCl);}
	if(UserCl.length = 0){$('#'+Usr+'_Error').text('Username is required.');}
	if(!CMS_Patterns.username.test(UserCl)){$('#'+Usr+'_Error').text('Only letters A–Z allowed.');};
}

