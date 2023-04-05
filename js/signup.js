let nameField = document.getElementById("nameField");
let surnameField = document.getElementById("surnameField");
let emailField = document.getElementById("emailField");
let passField = document.getElementById("passField");
let submitButton = document.getElementById("button");

const PASSWORD_REGEX = new RegExp(
  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/
);

let clearFields = () => {
  nameField.value = "";
  surnameField.value = "";
  emailField.value = "";
  passField.value = "";
};

window.addEventListener("pageshow", () => {
  clearFields();
});

submitButton.addEventListener("click", (ev) => {
  let name = nameField.value;
  let surname = surnameField.value;
  let email = emailField.value;
  let password = passField.value;

  if (name == "" || surname == "" || email == "" || password == "") {
    ev.stopPropagation();
    ev.preventDefault();
  } else {
    let http = new XMLHttpRequest();
    http.open("POST", "../views/register_form.php", true);
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    http.send(
      "name=" +
        name +
        "&surname=" +
        surname +
        "&email=" +
        email +
        "&password=" +
        password
    );
  }
});
