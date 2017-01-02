function limit50(elementId){
	if(document.getElementById(elementId).value.length>50){
		alert(document.getElementById(elementId).value.length);
		return true;
	}
	else{
		return false;
	}
}

function popUp(id){
	document.getElementById(id).classList.toggle('show');	
}

function validate(form){
	if(limit50('nameinput') || limit50('usernameinput') || limit50('passwdinput')){
		alert('ERROR! Input too long : max 50 characters');	
		return false;
	}
	if(document.getElementById('usernameinput').value.indexOf(' ')!=-1){
		alert('ERROR! username contains space');
		return false;
	}
	if(document.getElementById('passwdinput').value!=document.getElementById('repasswdinput').value){
		alert('ERROR! Password Don\'t match');
		return false;
	}
	return true;
}
