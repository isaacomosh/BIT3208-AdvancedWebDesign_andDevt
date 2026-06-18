// register.js

const registerForm = document.getElementById("registerForm");

const password = document.getElementById("password");
const strengthText = document.getElementById("passwordStrength");

// PASSWORD STRENGTH CHECKER
password.addEventListener("keyup", function(){

  const value = password.value;

  let strength = 0;

  // Length
  if(value.length >= 6){
    strength++;
  }

  // Uppercase
  if(/[A-Z]/.test(value)){
    strength++;
  }

  // Lowercase
  if(/[a-z]/.test(value)){
    strength++;
  }

  // Number
  if(/[0-9]/.test(value)){
    strength++;
  }

  // Special Character
  if(/[^A-Za-z0-9]/.test(value)){
    strength++;
  }

  // Display strength
  if(value.length === 0){

    strengthText.innerHTML = "";
    strengthText.className = "";

  }
  else if(strength <= 2){

    strengthText.innerHTML = "Weak Password";
    strengthText.className = "text-danger";

  }
  else if(strength <= 4){

    strengthText.innerHTML = "Medium Password";
    strengthText.className = "text-warning";

  }
  else{

    strengthText.innerHTML = "Strong Password";
    strengthText.className = "text-success";

  }

});


// FORM VALIDATION
registerForm.addEventListener("submit", function(event){

  let valid = true;

  const fullname = document.getElementById("fullname");
  const email = document.getElementById("email");
  const confirmPassword = document.getElementById("confirmPassword");

  // Full Name Validation
  if(fullname.value.trim() === ""){
    fullname.classList.add("is-invalid");
    valid = false;
  } else {
    fullname.classList.remove("is-invalid");
  }

  // Email Validation
  if(!email.value.includes("@")){
    email.classList.add("is-invalid");
    valid = false;
  } else {
    email.classList.remove("is-invalid");
  }

  // Password Validation
  if(password.value.length < 6){
    password.classList.add("is-invalid");
    valid = false;
  } else {
    password.classList.remove("is-invalid");
  }

  // Confirm Password Validation
  if(confirmPassword.value !== password.value){
    confirmPassword.classList.add("is-invalid");
    valid = false;
  } else {
    confirmPassword.classList.remove("is-invalid");
  }

  if(!valid){
    event.preventDefault();
  }

});