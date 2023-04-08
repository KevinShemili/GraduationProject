let usernameField = document.getElementById("floatingText");
let emailField = document.getElementById("floatingInput");
let passField = document.getElementById("floatingPassword");
let submitButton = document.getElementById("button");
let error = document.getElementById("invisible-error");

const PASSWORD_REGEX = new RegExp("^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]{8,}$");

let clearFields = () => {
  usernameField.value = "";
  emailField.value = "";
  passField.value = "";
};

window.addEventListener("pageshow", () => {
  clearFields();
});

submitButton.addEventListener("click", (ev) => {
  let username = usernameField.value;
  let email = emailField.value;
  let password = passField.value;

  if (username == "" || email == "" || password == "") {
    ev.stopPropagation();
    ev.preventDefault();
    error.innerText = "Fill in all fields.";
    return;
  }

  if (!PASSWORD_REGEX.test(password)) {
    error.innerText =
      "Invalid password format.\nAt least 8 characters and 1 number.";
    return;
  }

  let http = new XMLHttpRequest();
  http.open("POST", "../scripts/signupScript.php", true);
  http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  http.onreadystatechange = function () {
    if (http.readyState == 4 && http.status == 200) {
      let response = JSON.parse(http.responseText);
      if (response) {
        error.innerText = response;
      } else {
        // show modal...
      }
    }
  };

  http.send(
    "username=" + username + "&email=" + email + "&password=" + password
  );
});
