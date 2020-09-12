/*
 -Functionality for the searching algorithm (How to go through the different users that
 	have an account, when going through the swiping process).
 -Matching algorithm (This matches you [or doesnt] with someone. When you find someone, make it
 	so that if you swipe right [match] you give a value true. if that persons value of you is also
 	true, you match. if not, you either do not match or are pending. if you swipe left [nomatch]
 	then you assign a value of false. nothing more is done since you cannot match now.)
 -login/signup verification (This is to make sure when signing up, all fields are filled in
 	properly, and when logging in, that the account exists and the information is put in properly.)
 	VALIDATE: first name,
 			  last name,
 			  DOB,
 			  email,
 			  password,
 			  company name (For employers only).
 */

var resultEmail = false;
var resultPass = false;
var resultFirstname = false;
var resultLastname = false;
var resultBday = false;
var resultConfirm = false;
var resultCompany = false;

function chooseValue(event){
	if (document.getElementById("employer").checked){
		//document.getElementById("usertype").innerHTML = "employer";
		document.getElementById("usertype").value = "employer";
		//document.getElementById("company").addEventListener("blur", validateCompany, false);
	}
	else{
		//document.getElementById("usertype").innerHTML = "jobseeker";
		document.getElementById("usertype").value = "jobSeeker";
	}
}

//This will validate emails for signing up, and when logging in
function validateEmail(event){
	var e = event.currentTarget;
	var user = document.getElementById(e.id);
	var v = /^\w+@[a-zA-Z_]+\.[a-zA-Z]{2,3}$/; 
	document.getElementById(e.id + "_i").innerHTML = "";
	
	if (e.value == ""){
			document.getElementById(e.id + "_i").innerHTML = "Email is empty. Please enter in a email with proper format";
			resultEmail = false; 
	}
	else if (v.test(e.value) == false){
			document.getElementById(e.id + "_i").innerHTML = "Email is wrong format. Please enter in a email with proper format";
			resultEmail = false;
	}
	else{
			resultEmail = true;
	}
}

//This will validate the password for signing up, and for logging in
function validatePassword(event){
	var p = event.currentTarget;
	var pass = document.getElementById(p.id);
	var passv = /\w{8,}/;
	document.getElementById(p.id + "_i").innerHTML = "";
	
	if (p.value == ""){
			document.getElementById(p.id + "_i").innerHTML = "Password is empty. Please enter in a 8 or more character password";
			resultPass = false;
	}
	else if (passv.test(p.value) == false){
		document.getElementById(p.id + "_i").innerHTML = "Password is in inproper format. Please enter in a 8 or more character password";
		resultPass = false;
	}
	else{
		resultPass = true;
	}	
}

//Checks if the login is legal or not
function submitLogin(event){	
	if (!resultEmail || !resultPass){
		event.preventDefault();
	}
}

//This will validate first name for signing up
function validateFirstname(event){
	var n = event.currentTarget;
	var passn = /^[A-Za-z]+$/;
	document.getElementById(n.id + "_i").innerHTML = "";
	
	if (n.value == ""){
		document.getElementById(n.id + "_i").innerHTML = "The name is empty. Please enter your name.";
		resultFirstname = false;
	}
	else if (!passn.test(n.value)){
		document.getElementById(n.id + "_i").innerHTML = "The name has non-letter values. Please use letters only.";
		resultFirstname = false;
	}
	else{
		resultFirstname = true;
	}
}

//validate last name for signing up
function validateLastname(event){
	var n = event.currentTarget;
	var passn = /^[A-Za-z]+$/;
	document.getElementById(n.id + "_i").innerHTML = "";
	
	if (n.value == ""){
		document.getElementById(n.id + "_i").innerHTML = "The name is empty. Please enter your name.";
		resultLastname = false;
	}
	else if (!passn.test(n.value)){
		document.getElementById(n.id + "_i").innerHTML = "The name has non-letter values. Please use letters only.";
		resultLastname = false;
	}
	else{
		resultLastname = true;
	}
}

//validates the birthday for sign up
function validateBday(event){
	var b = event.currentTarget;
	var passb = /^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/;
	document.getElementById(b.id + "_i").innerHTML = "";
	
	if (b.value == ""){
		document.getElementById(b.id + "_i").innerHTML = "Date of Birth is empty. Please enter a date in formate: 00-00-0000";
		resultBday = false;
	}
	else if (!passb.test(b.value)){
		document.getElementById(b.id + "_i").innerHTML = "Date of Birth is incorrect format. Please enter a date in formate: 00-00-0000";
		resultBday = false;
	}
	else{
		resultBday = true;
	}
}

//confirms if the passwords match when signing up
function confirmPassword(event){
	var x = event.currentTarget;
	document.getElementById(x.id + "_i").innerHTML = "";
	var passv = /\w{8,}/;
	
	if (x.value == ""){
		document.getElementById(x.id + "_i").innerHTML = "Confirm password is empty. Please enter a matching password.";
		resultConfirm = false;
	}
	else if (x.value != document.getElementById("pswd").value){
		document.getElementById(x.id + "_i").innerHTML = "Confirm password does not match password. Please enter a matching password.";
		resultConfirm = false;
	}
	else if (!passv.test(x.value)){
		document.getElementById(x.id + "_i").innerHTML = "Original password is incorrect. Please change it, and re-match passwords.";
		resultConfirm = false;
	}
	else{
		resultConfirm = true;
	}
}

function submitSignup(event){
	if (document.getElementById("usertype").value == "jobSeeker"){
		if (!resultFirstname || !resultLastname || !resultEmail || !resultBday || !resultPass || !resultConfirm){
			event.preventDefault();
		}	
	}
	
	if (document.getElementById("usertype").value == "employer"){
		document.getElementById("usertype").innerHTML = "TEST";
		if (!resultFirstname || !resultLastname || !resultUser || !resultBday || !resultPass || !resultConfirm || !resultCompany){
			event.preventDefault();
		}
	}
}

//checks if all the signup information is legal for the job seeker
function submitSignupSeeker(event){
	if (!resultFirstname || !resultLastname || !resultEmail || !resultBday || !resultPass || !resultConfirm){
		document.getElementById("company_i").innerHTML = "TEST";
		event.preventDefault();
	}
}

//validates company name for signing up
function validateCompany(event){
	var c = event.currentTarget;
	var comp = document.getElementById(c.id);
	var compv = /^[A-Za-z0-9 ]+/;
	document.getElementById(c.id + "_i").innerHTML = "";
	
	if(document.getElementById("usertype").value == "employer"){
		if (c.value == ""){
			document.getElementById(c.id + "_i").innerHTML = "Company name is empty. Please enter the name of the company";
			resultCompany = false;
		}
		else if (compv.test(p.value) == false){
			document.getElementById(c.id + "_i").innerHTML = "Company name can only contain letters or numbers";
			resultCompany = false;
		}
		else
			resultCompany = true;
	}
}

//checks if all the signup information is legal for the employer
function submitSignupEmployer(event){
	if (!resultFirstname || !resultLastname || !resultUser || !resultBday || !resultPass || !resultConfirm || !resultCompany){
		event.preventDefault();
	}
}





