let basicTab = document.getElementById("pills-basic-tab");
let photoTab = document.getElementById("pills-photo-tab");
let keysTab = document.getElementById("pills-keys-tab");

let username = document.getElementById("exampleInputUsername");
let email = document.getElementById("exampleInputEmail1");
let password = document.getElementById("exampleInputPassword1");
let cPassword = document.getElementById("exampleInputPassword2");

let checkBox1 = document.getElementById("checkbox1");
let checkBox2 = document.getElementById("checkbox2");

let consumerKey = document.getElementById("consumerKey");
let consumerSecret = document.getElementById("consumerSecret");
let accessToken = document.getElementById("accessToken");
let accessTokenSecret = document.getElementById("accessTokenSecret");

let imageForm = document.getElementById("imgForm");
let imageInput = document.getElementById("imgInput");
let imgPreview = document.getElementById("imagePreview");

let saveBtn1 = document.getElementById("saveBtn1");
let saveBtn2 = document.getElementById("saveBtn2");
let saveBtn3 = document.getElementById("saveBtn3");
let removePhoto = document.getElementById("deletePhotoButton");

let error1 = document.getElementById("invisible-error1");
let error2 = document.getElementById("invisible-error2");
let error3 = document.getElementById("invisible-error3");

let modal = document.getElementById("exampleModalCenter");
let modal2 = document.getElementById("exampleModalCenter2");
let modalDeleteButton = document.getElementById("modalDelete");
var modalBody = document.getElementById("modaltext");

const urlParams = new URLSearchParams(window.location.search);

const PASSWORD_REGEX = new RegExp("^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9]{8,}$");

checkBox1.addEventListener("change", () => {
  if (checkBox1.checked) {
    password.disabled = true;
    cPassword.disabled = true;
    password.value = "*******";
    cPassword.value = "";
  } else {
    password.disabled = false;
    cPassword.disabled = false;
  }
});

checkBox2.addEventListener("change", () => {
  if (checkBox2.checked) {
    consumerKey.disabled = true;
    consumerSecret.disabled = true;
    accessToken.disabled = true;
    accessTokenSecret.disabled = true;
  } else {
    consumerKey.disabled = false;
    consumerSecret.disabled = false;
    accessToken.disabled = false;
    accessTokenSecret.disabled = false;
  }
});

imgInput.addEventListener("change", () => {
  let file = imageInput.files[0];
  let reader = new FileReader();
  reader.readAsDataURL(file);
  reader.addEventListener("load", () => {
    imagePreview.src = reader.result;
  });
});

basicTab.addEventListener("click", () => {
  const id = urlParams.get("id");

  let http = new XMLHttpRequest();
  http.open("GET", "../scripts/getUserJS.php?id=" + id, true);

  http.onreadystatechange = function () {
    if (http.readyState == 4 && http.status == 200) {
      let response = JSON.parse(http.responseText);
      if (response == "empty") {
        username.setAttribute("placeholder", "No value");
        email.setAttribute("placeholder", "No value");
        password.setAttribute("placeholder", "No value");
        cPassword.setAttribute("placeholder", "No value");
      } else {
        username.value = response.username;
        email.value = response.email;
        password.value = "";
        cPassword.value = "";
      }
    }
  };

  http.send();
});

keysTab.addEventListener("click", () => {
  const id = urlParams.get("id");

  let http = new XMLHttpRequest();
  http.open("GET", "../scripts/getKeys.php?id=" + id, true);

  http.onreadystatechange = function () {
    if (http.readyState == 4 && http.status == 200) {
      let responseKeys = JSON.parse(http.responseText);
      if (Object.keys(responseKeys).length === 0) {
        consumerKey.setAttribute("placeholder", "No Key");
        consumerSecret.setAttribute("placeholder", "No Key");
        accessToken.setAttribute("placeholder", "No Key");
        accessTokenSecret.setAttribute("placeholder", "No Key");
      } else {
        consumerKey.value = responseKeys.consumer_key;
        consumerSecret.value = responseKeys.consumer_secret;
        accessToken.value = responseKeys.access_token;
        accessTokenSecret.value = responseKeys.access_token_secret;
      }
    }
  };

  http.send();
});

window.onload = () => {
  const id = urlParams.get("id");

  let http = new XMLHttpRequest();
  http.open("GET", "../scripts/getUserJS.php?id=" + id, true);

  http.onreadystatechange = function () {
    if (http.readyState == 4 && http.status == 200) {
      let response = JSON.parse(http.responseText);
      if (response == "empty") {
        username.setAttribute("placeholder", "No value");
        email.setAttribute("placeholder", "No value");
        password.setAttribute("placeholder", "No value");
        cPassword.setAttribute("placeholder", "No value");
      } else {
        username.value = response.username;
        email.value = response.email;
        password.value = "*******";
        cPassword.value = "";
      }
    }
  };

  http.send();
};

saveBtn1.addEventListener("click", () => {
  const id = urlParams.get("id");

  if (checkBox1.checked) {
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "../scripts/updateUser.php", true);

    var form = new FormData();

    form.append("functionName", "updateBasic");
    form.append("id", id);

    if (username.value == "" || username.value == null) {
      error1.innerText = "Fill in all fields.";
      return;
    }

    if (email.value == "" || email.value == null) {
      error1.innerText = "Fill in all fields.";
      return;
    }

    form.append("username", username.value);
    form.append("email", email.value);

    xhr.send(form);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        if (response == 200) {
          $(modal).modal("show");
          setTimeout(() => {
            modalBody.innerHTML = "Saved.";
            $(modal).modal("hide");
            location.reload();
          }, 3000);
        } else {
          error.innerText = response;
        }
      }
    };
  } else {
    var xhr = new XMLHttpRequest();

    xhr.open("POST", "../scripts/updateUser.php", true);

    var form = new FormData();

    form.append("functionName", "updateFull");
    form.append("id", id);

    if (username.value == "" || username.value == null) {
      error1.innerText = "Fill in all fields.";
      return;
    } else {
      form.append("username", username.value);
    }

    if (email.value == "" || email.value == null) {
      error1.innerText = "Fill in all fields.";
      return;
    } else {
      form.append("email", email.value);
    }

    if (password.value == "" || password.value == null) {
      error1.innerText = "Fill in all fields.";
      return;
    }

    if (cPassword.value == "" || cPassword.value == null) {
      error1.innerText = "Fill in all fields.";
      return;
    }

    if (password.value != cPassword.value) {
      error1.innerText = "Passwords don't match.";
      return;
    }

    if (!PASSWORD_REGEX.test(password.value)) {
      error1.innerText =
        "Invalid password format.\nAt least 8 characters and 1 number.";
      return;
    }

    form.append("password", password.value);
    form.append("cpassword", cPassword.value);

    xhr.send(form);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        if (response == 200) {
          $(modal).modal("show");
          setTimeout(() => {
            modalBody.innerHTML = "Saved.";
            $(modal).modal("hide");
            location.reload();
          }, 3000);
        } else {
          error1.innerText = response;
        }
      }
    };
  }
});

saveBtn2.addEventListener("click", () => {
  const id = urlParams.get("id");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../scripts/updatePhoto.php");
  let form = new FormData();

  form.append("id", id);

  if (imgInput.files[0] != null) {
    form.append("photoForm", imgInput.files[0], imgInput.files[0].name);
  } else {
    error2.innerText = "No photo uploaded.";
    return;
  }

  xhr.send(form);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      if (response == 200) {
        $(modal).modal("show");
        setTimeout(() => {
          modalBody.innerHTML = "Saved.";
          $(modal).modal("hide");
          location.reload();
        }, 3000);
      } else {
        error2.innerText = response;
      }
    }
  };
});

$(document).ready(function () {
  $("#modalCancel").click(function () {
    $("#exampleModalCenter2").modal("hide");
  });
});

$(document).ready(function () {
  $("#closeModal").click(function () {
    $("#exampleModalCenter2").modal("hide");
  });
});

removePhoto.addEventListener("click", () => {
  $(modal2).modal("show");
});

modalDeleteButton.addEventListener("click", () => {
  const id = urlParams.get("id");

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../scripts/deletePhoto.php");
  let form = new FormData();

  form.append("id", id);

  xhr.send(form);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      if (response == 200) {
        $("#exampleModalCenter2").modal("hide");
        $(modal).modal("show");
        document.getElementById("exampleModalLongTitle").innerText = "";
        modalBody.innerHTML = "Deleting...";
        setTimeout(() => {
          modalBody.innerHTML = "Deleted.";
          $(modal).modal("hide");
          location.reload();
        }, 3000);
      } else {
        error2.innerText = response;
      }
    }
  };
});

saveBtn3.addEventListener("click", () => {
  if (!checkBox2.checked) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../scripts/updateKeys.php", true);

    var form = new FormData();
    const id = urlParams.get("id");
    form.append("id", id);

    if (consumerKey.value == "" || consumerKey.value == null) {
      error3.innerText = "Fill in all fields.";
      return;
    }

    if (consumerSecret.value == "" || consumerSecret.value == null) {
      error3.innerText = "Fill in all fields.";
      return;
    }

    if (accessToken.value == "" || accessToken.value == null) {
      error3.innerText = "Fill in all fields.";
      return;
    }

    if (accessTokenSecret.value == "" || accessTokenSecret.value == null) {
      error3.innerText = "Fill in all fields.";
      return;
    }

    form.append("consumerKey", consumerKey.value);
    form.append("consumerSecret", consumerSecret.value);
    form.append("accessToken", accessToken.value);
    form.append("accessTokenSecret", accessTokenSecret.value);

    xhr.send(form);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
        let response = JSON.parse(xhr.responseText);
        if (response == 200) {
          $(modal).modal("show");
          setTimeout(() => {
            modalBody.innerHTML = "Saved.";
            $(modal).modal("hide");
            location.reload();
          }, 3000);
        } else {
          error3.innerText = response;
        }
      }
    };
  }
});
