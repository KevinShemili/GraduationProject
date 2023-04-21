const urlParams = new URLSearchParams(window.location.search);
// Chart Global Color
Chart.defaults.color = "#6C7293";
Chart.defaults.borderColor = "#000000";

let query = document.getElementById("query");
let desc = document.getElementById("desc");
let nr = document.getElementById("nr");

let positive, negative, neutral;

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
        positive = response.positive;
        negative = response.negative;
        neutral = response.neutral;

        var ctx4 = $("#bar-chart").get(0).getContext("2d");
        var myChart4 = new Chart(ctx4, {
          type: "bar",
          data: {
            labels: ["Negative", "Neutral", "Positive"],
            datasets: [
              {
                backgroundColor: [
                  "rgba(235, 22, 22, .7)", // Negative - Red
                  "rgba(255, 165, 0, .7)", // Neutral - Orange
                  "rgba(76, 175, 80, .7)", // Positive - Green
                ],
                data: [negative, neutral, positive],
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
            plugins: {
              tooltip: {
                callbacks: {
                  title: function (tooltipItems) {
                    const index = tooltipItems[0].dataIndex;
                    const label = tooltipItems[0].label;
                    const color =
                      index === 0 ? "Red" : index === 1 ? "Orange" : "Green";
                    return `Color ${color}: ${label}`;
                  },
                },
              },
            },
          },
        });

        // Pie Chart
        var ctx5 = $("#pie-chart").get(0).getContext("2d");
        var myChart5 = new Chart(ctx5, {
          type: "pie",
          data: {
            labels: ["Negative", "Neutral", "Positive"],
            datasets: [
              {
                backgroundColor: [
                  "rgba(235, 22, 22, .7)", // Negative - Red
                  "rgba(255, 165, 0, .7)", // Neutral - Orange
                  "rgba(76, 175, 80, .7)", // Positive - Green
                ],
                data: [negative, neutral, positive],
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
            labels: ["Negative", "Neutral", "Positive"],
            datasets: [
              {
                backgroundColor: [
                  "rgba(235, 22, 22, .7)", // Negative - Red
                  "rgba(255, 165, 0, .7)", // Neutral - Orange
                  "rgba(76, 175, 80, .7)", // Positive - Green
                ],
                data: [negative, neutral, positive],
              },
            ],
          },
          options: {
            responsive: true,
          },
        });
      } else {
        error.innerText = response.error;
      }
    }
  };
};
