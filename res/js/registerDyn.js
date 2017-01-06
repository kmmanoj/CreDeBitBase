var nameInput=document.getElementById("nameinput");
var usernameInput=document.getElementById("usernameinput");
var passwdInput=document.getElementById("passwdinput");
var repasswdInput=document.getElementById("repasswdinput");
var registerButton=document.getElementById("registerbutton");

var nameAlertMsg=document.getElementById("name-alert-message");
var usernameAlertMsg=document.getElementById("username-alert-message");
var passwdAlertMsg=document.getElementById("passwd-alert-message");
var repasswdAlertMsg=document.getElementById("repasswd-alert-message");

var nameAlertImg=document.getElementById("name-alert-image");
var usernameAlertImg=document.getElementById("username-alert-image");
var passwdAlertImg=document.getElementById("passwd-alert-image");
var repasswdAlertImg=document.getElementById("repasswd-alert-image");

var beganNameInput=false;
var beganUsernameInput=false;
var beganPasswdInput=false;
var beganRepasswdInput=false;
var alledited=false;


function disable(regbutton){
	regbutton.disabled=true;
	regbutton.style.backgroundColor='rgb(100,100,100)';
}

function enable(regbutton){
	regbutton.disabled=false;
	regbutton.style.backgroundColor='rgb(255,255,255)';
}

disable(registerbutton);


function excessof50(element) {
	if(element.value.length>50){
		return true;
	} else {
		return false;
	}
}

function commentName() {
	if(!beganNameInput && nameInput.value!="") {
		beganNameInput=true;
	}
	if(beganNameInput){
		nameAlertImg.src="res/images/error.png";
		if(excessof50(nameInput)) {
			nameAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Name too long. Limit = 50 Characters</span>";
			return true;
		} else if(nameInput.value.length==0){
			nameAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Name field cannot be Empty</span>";
			return true;
		} else {
			nameAlertMsg.innerHTML="<span style='color:rgb(20,255,20)'>Good to go !!</span>";
			nameAlertImg.src="res/images/done.png";
			return false;
		}
	} 
}

function commentUsername() {
	if(!beganUsernameInput && usernameInput.value!="") {
		beganUsernameInput=true;
	}
	if(beganUsernameInput){
		usernameAlertImg.src="res/images/error.png";
		if(excessof50(usernameInput)) {
			usernameAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Username too long. Limit = 50 Characters</span>";
			return true;
		} else if(usernameInput.value.length==0){
			usernameAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Username field cannot be Empty</span>";
			return true;
		} else if(usernameInput.value.indexOf(' ')!=-1){
			usernameAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>username shouldn't contain space</span>";
			return true;
		} else {
			usernameAlertMsg.innerHTML="<span style='color:rgb(20,255,20)'>Good to go !!</span>";
			usernameAlertImg.src="res/images/done.png";
			return false;
		}
	} 
}

function commentPasswd() {
	if(!beganPasswdInput && passwdInput.value!="") {
		beganPasswdInput=true;
	}
	if(beganPasswdInput){
		passwdAlertImg.src="res/images/error.png";
		if(excessof50(passwdInput)) {
			passwdAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Password too long. Limit = 50 Characters</span>";
			return true;
		} else if(passwdInput.value.length==0){
			passwdAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Password shouldn't be Empty</span>";
			return true;
		} else {
			passwdAlertMsg.innerHTML="<span style='color:rgb(20,255,20)'>Good to go !!</span>";
			passwdAlertImg.src="res/images/done.png";
			return false;
		}
	} 
}

function commentRepasswd() {
	if(!beganRepasswdInput && repasswdInput.value!="") {
		beganRepasswdInput=true;
	}
	if(beganRepasswdInput){
		if(passwdInput.value.length==0) {
			repasswdAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Password is Empty</span>";
			repasswdAlertImg.src="res/images/error.png";
			return true;
		} else if(passwdInput.value!=repasswdInput.value) {
			repasswdAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Passwords Don't match</span>";
			repasswdAlertImg.src="res/images/error.png";
			return true;
		} else {
			repasswdAlertMsg.innerHTML="<span style='color:rgb(20,255,20)'>Good to go !!</span>";
			repasswdAlertImg.src="res/images/done.png";
			return false;
		}
	}
}

var error=false;
function comment() {
	error=false;
	error=commentName() || error;
	error=commentUsername() || error;
	error=commentPasswd() || error;
	error=commentRepasswd() || error;
	if(alledited) {
		if(error) {
			disable(registerButton);
		} else {
			enable(registerButton);
		}
	} else {
		alledited=beganNameInput && beganUsernameInput && beganPasswdInput && beganRepasswdInput;
	}
}

window.setInterval(comment,100);