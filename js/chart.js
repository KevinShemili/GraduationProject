const urlParams = new URLSearchParams(window.location.search);
// Chart Global Color
Chart.defaults.color = "#6C7293";
Chart.defaults.borderColor = "#000000";

let query = document.getElementById("query");
let desc = document.getElementById("desc");
let nr = document.getElementById("nr");
let algo = document.getElementById("algo");

let table = document.getElementById("table-body");

let positive, negative, neutral;

function loadCSV(file, callback) {
  let xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      callback(xhr.responseText);
    }
  };
  xhr.open("GET", file, true);
  xhr.send(null);
}

// Populate the table
function populateTable(csvData) {
  let parsedData = Papa.parse(csvData, {
    header: true,
    skipEmptyLines: true,
  });

  for (let row of parsedData.data) {
    table.innerHTML += `
        <tr class="text-center">
            <td>${row.tweet_id}</td>
            <td>${row.text}</td>
            <td>${row.retweet_count}</td>
            <td>${row.created_at}</td>
        </tr>
        `;
  }
}

window.onload = () => {
  const analyseId = urlParams.get("analyseId");

  var xhr = new XMLHttpRequest();

  xhr.open("POST", "../scripts/getAnalyses.php", true);

  let form = new FormData();
  form.append("functionName", "getSentiment");
  form.append("analyseId", analyseId);

  xhr.send(form);

  xhr.onreadystatechange = function () {
    if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
      let response = JSON.parse(xhr.responseText);
      if (response.status == 200) {
        strongPositive = response.strongPositive;
        strongNegative = response.strongNegative;
        neutral = response.neutral;
        weakPositive = response.weakPositive;
        weakNegative = response.weakNegative;
        query.innerText = "Query: " + response.query;
        nr.innerText = "Number of Tweets: " + response.nr;
        algo.innerText = "Algorithm used: " + response.algorithm.toUpperCase();
        desc.innerText = "About: " + response.description;
        csvFile = "../csv/" + response.csvFile;

        var ctx4 = $("#bar-chart").get(0).getContext("2d");
        var myChart4 = new Chart(ctx4, {
          type: "bar",
          data: {
            labels: [
              "Strong Negative",
              "Weak Negative",
              "Neutral",
              "Weak Positive",
              "Strong Positive",
            ],
            datasets: [
              {
                backgroundColor: [
                  "rgba(153, 0, 0, .7)", // Strong Negative - Dark Red
                  "rgba(255, 102, 102, .7)", // Weak Negative - Light Red
                  "rgba(128, 128, 128, .7)", // Neutral - Gray
                  "rgba(102, 255, 102, .7)", // Weak Positive - Light Green
                  "rgba(0, 153, 0, .7)", // Strong Positive - Dark Green
                ],
                data: [
                  strongNegative,
                  weakNegative,
                  neutral,
                  weakPositive,
                  strongPositive,
                ],
              },
            ],
          },
          options: {
            responsive: true,
            scales: {
              y: {
                beginAtZero: true,
              },
            },
          },
        });

        // Pie Chart
        var ctx5 = $("#pie-chart").get(0).getContext("2d");
        var myChart5 = new Chart(ctx5, {
          type: "pie",
          data: {
            labels: [
              "Strong Negative",
              "Weak Negative",
              "Neutral",
              "Weak Positive",
              "Strong Positive",
            ],
            datasets: [
              {
                backgroundColor: [
                  "rgba(153, 0, 0, .7)", // Strong Negative - Dark Red
                  "rgba(255, 102, 102, .7)", // Weak Negative - Light Red
                  "rgba(128, 128, 128, .7)", // Neutral - Gray
                  "rgba(102, 255, 102, .7)", // Weak Positive - Light Green
                  "rgba(0, 153, 0, .7)", // Strong Positive - Dark Green
                ],
                data: [
                  strongNegative,
                  weakNegative,
                  neutral,
                  weakPositive,
                  strongPositive,
                ],
              },
            ],
          },
          options: {
            responsive: true,
          },
        });

        // Doughnut Chart
        var ctx6 = $("#doughnut-chart").get(0).getContext("2d");
        var myChart6 = new Chart(ctx6, {
          type: "doughnut",
          data: {
            labels: [
              "Strong Negative",
              "Weak Negative",
              "Neutral",
              "Weak Positive",
              "Strong Positive",
            ],
            datasets: [
              {
                backgroundColor: [
                  "rgba(153, 0, 0, .7)", // Strong Negative - Dark Red
                  "rgba(255, 102, 102, .7)", // Weak Negative - Light Red
                  "rgba(128, 128, 128, .7)", // Neutral - Gray
                  "rgba(102, 255, 102, .7)", // Weak Positive - Light Green
                  "rgba(0, 153, 0, .7)", // Strong Positive - Dark Green
                ],
                data: [
                  strongNegative,
                  weakNegative,
                  neutral,
                  weakPositive,
                  strongPositive,
                ],
              },
            ],
          },
          options: {
            responsive: true,
          },
        });

        if (csvFile != "../csv/") {
          loadCSV(csvFile, function (csvData) {
            populateTable(csvData);
          });
        }
      } else {
        error.innerText = response.error;
      }
    }
  };
};
