<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Progress Tracker</title>
    <script>
        function fetchQueueProgress() {
            fetch("{{ url('/api/queue/progress') }}")
                .then(response => response.json())
                .then(data => {
                    let html = "<h2>Queue Progress</h2>";
                    data.forEach(job => {
                        html += `<p><strong>Job ID:</strong> ${job.job_id} | <strong>Status:</strong> ${job.status} | <strong>Message:</strong> ${job.message}</p>`;
                    });
                    document.getElementById("queueProgress").innerHTML = html;
                })
                .catch(error => console.log(error));
        }

        // Auto-refresh every 5 seconds
        setInterval(fetchQueueProgress, 5000);
        window.onload = fetchQueueProgress;
    </script>
</head>
<body>
<h1>Queue Progress</h1>
<div id="queueProgress">
    <p>Loading...</p>
</div>
</body>
</html>
