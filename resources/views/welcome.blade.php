<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Manager</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            margin: 10px;
        }
        .start { background-color: green; color: white; }
        .stop { background-color: red; color: white; }
    </style>
    <script>
        function controlQueue(action) {
            fetch("{{ url('/queue') }}/" + action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                }
            })
                .then(response => response.json())
                .then(data => alert(data.message))
                .catch(error => alert("Something went wrong!"));
        }
    </script>
</head>
<body>
<h1>Queue Manager</h1>
<button class="start" onclick="controlQueue('start')">Start Queue</button>
<button class="stop" onclick="controlQueue('stop')">Stop Queue</button>
</body>
</html>
