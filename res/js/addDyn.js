var clientInput=document.getElementById("clientinput");
var dateInput=document.getElementById("dateinput");
var addButton=document.getElementById("addbutton");

var clientAlertMsg=document.getElementById("client-alert-message");
var dateAlertMsg=document.getElementById("date-alert-message");

var clientAlertImg=document.getElementById("client-alert-image");
var dateAlertImg=document.getElementById("date-alert-image");

var beganClientInput=false;
var beganDateInput=false;

function disable(button){
	button.disabled=true;
	button.style.backgroundColor='rgb(100,100,100)';
}

function enable(button){
	button.disabled=false;
	button.style.backgroundColor='rgb(255,255,255)';
}

disable(addButton);

function excessof50(element) {
	if(element.value.length>50){
		return true;
	} else {
		return false;
	}
}

function commentClient() {
	if(!beganClientInput && clientInput.value!="") {
		beganClientInput=true;
	}
	if(beganClientInput){
		clientAlertImg.src="res/images/error.png";
		if(excessof50(clientInput)) {
			clientAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Client Name too long. Limit = 50 Characters</span>";
			return true;
		} else if(clientInput.value.length==0){
			clientAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Client Name field cannot be Empty</span>";
			return true;
		} else {
			clientAlertMsg.innerHTML="<span style='color:rgb(20,255,20)'>Good to go !!</span>";
			clientAlertImg.src="res/images/done.png";
			return false;
		}
	} 
}

function invalidFormat() {
	if(dateInput.value.split('/').length!=3){
		return true;
	} else {
		return false;
	}
}

function invaliDate() {
	var date=dateInput.value.split('/');
	var y=parseInt(date[0]);
	var m=parseInt(date[1]);
	var d=parseInt(date[2]);
	if(isNaN(y) || isNaN(m) || isNaN(d)){
		return true;
	}
	else if(y>0){
		if(m==1 || m==3 || m==5 || m==7 || m==8 || m==10 || m==12) {
			return d>31;
		} else if(m==4 || m==6 || m==9 || m==11) {
			return d>30;
		} else if(m==2) {
			if(y%4==0){
				return d>29;
			} else {
				return d>28;
			}
		} else {
			return true;
		}
	} else {
		return true;
	}
}

function commentDate() {
	if(!beganDateInput && dateInput.value!="") {
		beganDateInput=true;
	}
	if(beganDateInput){
		dateAlertImg.src="res/images/error.png";
		if(invalidFormat()) {
			dateAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Format: yyyy/mm/dd </span>";
			return true;
		} else if(invaliDate()) {
			dateAlertMsg.innerHTML="<span style='color:rgb(255,40,40)'>Invalid Date</span>";
			return true;
		} else {
			dateAlertMsg.innerHTML="<span style='color:rgb(20,255,20)'>Good to go !!</span>";
			dateAlertImg.src="res/images/done.png";
			return false;	
		}
	}
}
var alledited=false;
var error=false;
function comment() {
	error=false;
	error=commentClient() || error;
	error=commentDate() || error;
	if(alledited) {
		if(error) {
			disable(addButton);
		} else {
			enable(addButton);
		}
	} else {
		alledited=beganClientInput && beganDateInput;
	}
}

window.setInterval(comment,100);
var button=document.getElementById('extrafieldbutton');

function addField(){
	var fieldname=prompt("Field name: ");
	var row=document.createElement("tr");
	var d=[]
	for(var i=0;i<6;i++){
		d.push(document.createElement("td"));
		row.appendChild(d[i]);
	}
	d[0].innerHTML="<label>"+fieldname+"</label>";
	d[1].innerHTML=":";
	d[2].innerHTML="<input type='text'/>";
	d[3].innerHTML="<input type='button' value='delete'/>";
	d[3].onclick=function(){
		this.parentNode.parentNode.removeChild(this.parentNode);
	}
	button.parentNode.insertBefore(row,button);
}
button.onclick=addField;