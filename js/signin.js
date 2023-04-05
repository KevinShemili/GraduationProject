let emailField = document.getElementById("emailField");
let passField = document.getElementById("passField");
let submitButton = document.getElementById("button");
let error = document.getElementById("error-msg");

let clearFields = () => {
  emailField.value = "";
  passField.value = "";
};

window.addEventListener("pageshow", () => {
  clearFields();
});

submitButton.addEventListener("click", (ev) => {
  let email = emailField.value;
  let password = passField.value;

  if (email == "" || password == "") {
    ev.stopPropagation();
    ev.preventDefault();
  } else {
    let http = new XMLHttpRequest();
    http.open("POST", "../controller/login.php");
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send("email=" + email + "&password=" + password);
  }
});
