let emailField = document.getElementById("floatingInput");
let passField = document.getElementById("floatingPassword");
let submitButton = document.getElementById("button");
let error = document.getElementById("invisible-error");

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
    error.innerText = "Fill in all fields.";
    return;
  } else {
    let http = new XMLHttpRequest();
    http.open("POST", "../scripts/signinScript.php");
    http.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    http.onreadystatechange = function () {
      if (http.readyState == 4 && http.status == 200) {
        let response = JSON.parse(http.responseText);
        if (response == 200) {
          window.location.href = "../index.php";
        } else {
          error.innerText = response;
        }
      }
    };

    http.send("email=" + email + "&password=" + password);
  }
});
