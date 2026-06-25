// script.js

const form = document.getElementById("loginForm");

form.addEventListener("submit", function (event) {

  let isValid = true;

  const email = document.getElementById("email");
  const password = document.getElementById("password");

  // Email validation
  if (!email.value || !email.value.includes("@")) {
    email.classList.add("is-invalid");
    isValid = false;
  } else {
    email.classList.remove("is-invalid");
  }

  // Password validation
  if (!password.value || password.value.length < 6) {
    password.classList.add("is-invalid");
    isValid = false;
  } else {
    password.classList.remove("is-invalid");
  }

  if (!isValid) {
    event.preventDefault();
  }

});