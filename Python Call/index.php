<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP and Python Integration</title>
    <style>
        #loading-indicator {
            display: none;
        }
    </style>
</head>

<body>
    <h1>PHP and Python Integration</h1>
    <button id="fetch-data-btn">Fetch Data</button>
    <div id="loading-indicator">Loading...</div>
    <div id="data-container"></div>

    <script>
        document.getElementById("fetch-data-btn").addEventListener("click", function() {
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    document.getElementById("loading-indicator").style.display = "none";
                    if (xhr.status === 200) {
                        document.getElementById("data-container").innerHTML = xhr.responseText;
                    } else {
                        document.getElementById("data-container").innerHTML = "Error: " + xhr.status;
                    }
                }
            };

            xhr.open("GET", "call_main.php", true);
            xhr.send();
            document.getElementById("loading-indicator").style.display = "block";
        });
    </script>
</body>

</html>