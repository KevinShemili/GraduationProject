let tableBody = document.getElementById("table-body");

let detailsButton = document.getElementById("details-button");
let deleteButton = document.getElementById("delete-button");

const urlParams = new URLSearchParams(window.location.search);

window.onload = () => {
  getAnalyses((analyses) => {
    prepareContent(analyses);
  });
};

let getAnalyses = (callback) => {
  const id = urlParams.get("id");

  var xhr = new XMLHttpRequest();

  xhr.open("POST", "../scripts/getAnalyses.php", true);

  let form = new FormData();
  form.append("functionName", "getAllAnalyses");
  form.append("id", id);

  xhr.send(form);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      if (response.status == 200) {
        callback(response.data);
      } else {
        error.innerText = response.error;
      }
    }
  };
};

let prepareContent = (analyses) => {
  tableBody.innerHTML = "";
  if (analyses) {
    for (let analyse of analyses) {
      tableBody.innerHTML += `
        <tr class="text-center">
            <td>${analyse.query}</td>
            <td>${analyse.nrTweets}</td>
            <td>${analyse.dateCreated}</td>
            <td>
                <a class="btn btn-sm btn-info" id="details-button" href="chart.php?analyseId=${analyse.id}" self-id="${analyse.id}">Details</a>
                <a class="btn btn-sm btn-primary" id="delete-button" href="" self-id="${analyse.id}">Delete</a>
            </td>
        </tr>
        `;
    }
  } else {
    content.innerHTML += `<h3 style="color: crimson;">No analysis avaliable</h3>`;
  }
};
