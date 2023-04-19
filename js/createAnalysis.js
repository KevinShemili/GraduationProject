let rangeInput = document.getElementById("customRange1");
let rangeValue = document.getElementById("rangeValue");

let queryField = document.getElementById("topicField");
let descriptionField = document.getElementById("descField");
let algorithmField = document.getElementById("algorithms");

let error = document.getElementById("invisible-error1");

let btn = document.getElementById("analyseBtn");

let modal = document.getElementById("exampleModalCenter");
let modalYes = document.getElementById("modalYes");
let modalCancel = document.getElementById("modalCancel");

let modal2 = document.getElementById("exampleModalCenter2");

const urlParams = new URLSearchParams(window.location.search);

window.onload = () => {
  rangeInput.value = 275;
  rangeValue.textContent = rangeInput.value;
  queryField.value = "";
  descriptionField.value = "";
  algorithmField.value = "noValue";
};

rangeInput.addEventListener("input", () => {
  rangeValue.textContent = rangeInput.value;
});

modalYes.addEventListener("click", () => {
  window.location.href = "../views/profile.php";
});

modalCancel.addEventListener("click", () => {
  $(modal).modal("hide");
});

$(document).ready(function () {
  $("#closeModal").click(function () {
    $(modal).modal("hide");
  });
});

$(document).ready(function () {
  $("#closeModal2").click(function () {
    $(modal).modal("hide");
  });
});

btn.addEventListener("click", () => {
  if (queryField.value == "" || queryField.value == null) {
    error.innerText = "Fill in all fields.";
    return;
  }

  if (descriptionField.value == "" || descriptionField.value == null) {
    error.innerText = "Fill in all fields.";
    return;
  }

  if (algorithmField.value == "noValue") {
    error.innerText = "Choose an algorithm.";
    return;
  }

  const id = urlParams.get("id");

  let http = new XMLHttpRequest();
  http.open("GET", "../scripts/getKeys.php?id=" + id, true);

  http.onreadystatechange = function () {
    if (http.readyState == 4 && http.status == 200) {
      let responseKeys = JSON.parse(http.responseText);
      if (Object.keys(responseKeys).length === 0) {
        $(modal).modal("show");
        return;
      } else {
        consumerKey = responseKeys.consumer_key;
        consumerSecret = responseKeys.consumer_secret;
        accessToken = responseKeys.access_token;
        accessTokenSecret = responseKeys.access_token_secret;

        // Move the second HTTP request inside the first HTTP request's callback
        var http2 = new XMLHttpRequest();
        http2.open("POST", "../scripts/callPython.php", true);

        let form = new FormData();
        form.append("id", id);

        form.append("query", queryField.value);
        form.append("description", descriptionField.value);
        form.append("algorithm", algorithmField.value);
        form.append("tweetNr", rangeInput.value);

        form.append("consumerKey", consumerKey);
        form.append("consumerSecret", consumerSecret);
        form.append("accessToken", accessToken);
        form.append("accessTokenSecret", accessTokenSecret);

        http2.send(form);

        http2.onreadystatechange = function () {
          if (
            http2.readyState === XMLHttpRequest.DONE &&
            http2.status === 200
          ) {
            let response = JSON.parse(http2.responseText);
            if (response == 200) {
              window.location.href = "../views/chart.php";
            } else if (response.status == 500) {
              $(modal2).modal("show");
            } else {
              error.innerText = response;
            }
          }
        };
      }
    }
  };

  http.send();
});
