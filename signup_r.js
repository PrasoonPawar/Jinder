document.getElementById("fname").addEventListener("blur", validateFirstname, false);
document.getElementById("lname").addEventListener("blur", validateLastname, false);
document.getElementById("email").addEventListener("blur", validateEmail, false);
document.getElementById("dob").addEventListener("blur", validateBday, false);
document.getElementById("pswd").addEventListener("blur", validatePassword, false);
document.getElementById("pswdr").addEventListener("blur", confirmPassword, false);
document.getElementById("company").addEventListener("blur", validateCompany, false)
document.getElementById("employer").addEventListener("change", chooseValue, false);
document.getElementById("jobSeeker").addEventListener("change", chooseValue, false);
//document.getElementById("usertype").addEventListener("change", chooseValue, false)
document.getElementById("SignUp1").addEventListener("submit", submitSignup, false);