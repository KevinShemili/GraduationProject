let username = document.getElementById("exampleInputUsername");
let email = document.getElementById("exampleInputEmail1");
let password = document.getElementById("exampleInputPassword1");
let cPassword = document.getElementById("exampleInputPassword2");

let checkBox = document.getElementById("checkbox");

let consumerKey = document.getElementById("consumerKey");
let consumerSecret = document.getElementById("consumerSecret");
let accessToken = document.getElementById("accessToken");
let accessTokenSecret = document.getElementById("accessTokenSecret");

let imageForm = document.getElementById("imgForm");
let imageInput = document.getElementById("imgInput");
let imgPreview = document.getElementById("imagePreview");

let saveBtn = document.getElementById("saveBtn");

const urlParams = new URLSearchParams(window.location.search);

let numberOnlyRegex = /^[0-9]+$/;

checkBox.addEventListener("change", () => {
  if (checkBox.checked) {
    consumerKey.disabled = true;
    consumerSecret.disabled = true;
    accessToken.disabled = true;
    accessTokenSecret.disabled = true;
    password.disabled = true;
    cPassword.disabled = true;
  } else {
    consumerKey.disabled = false;
    consumerSecret.disabled = false;
    accessToken.disabled = false;
    accessTokenSecret.disabled = false;
    password.disabled = false;
    cPassword.disabled = false;
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

window.onload = () => {
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

  let http2 = new XMLHttpRequest();
  http2.open("GET", "../scripts/getUserJS.php?id=" + id, true);

  http2.onreadystatechange = function () {
    if (http2.readyState == 4 && http2.status == 200) {
      let response = JSON.parse(http2.responseText);
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

  http2.send();
};

saveBtn.addEventListener("click", () => {
  const prdid = urlParams.get("prdid");
  let http = new XMLHttpRequest();
  http.open("POST", "../controller/updateProduct.php");
  let form = new FormData();
  if (img.files[0] != null) {
    form.append("photoForm", img.files[0], img.files[0].name);
  }
  form.append("prdid", prdid);
  if (productName.value != null) {
    form.append("productName", productName.value);
  }
  if (productBrand.value != null) {
    form.append("productBrand", productBrand.value);
  }
  if (productPrice.value != null) {
    form.append("productPrice", productPrice.value);
  }
  if (productDesc.value != null) {
    form.append("productDesc", productDesc.value);
  }
  if (checkBox.checked) {
    form.append("onSale", 1);
    if (salePercentage.value != null) {
      form.append("salePercentage", salePercentage.value);
    }
  } else {
    form.append("onSale", 0);
  }
  if (productCategory.options[productCategory.selectedIndex].value != null) {
    form.append(
      "category",
      productCategory.options[productCategory.selectedIndex].value
    );
  }
  form.append("qty", parseInt(quantityNr.innerText));
  http.send(form);
  http.addEventListener("load", () => {
    let response = http.responseText;
    if (response != "error") {
      window.location.href = "../views/admin_products_panel.php";
    }
  });
});
