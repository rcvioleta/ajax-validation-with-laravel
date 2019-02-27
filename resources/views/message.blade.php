<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Ajax Test</title>
</head>
<body>
    <script>
        const changeMessage = () => {
            const message = document.getElementById('message');
            fetch('/getmessage')
            .then(resp => resp.json())
            .then(data =>{
                message.innerHTML = `
                    <strong>Sender:</strong> ${data.sender} <br>
                    <strong>Message:</strong> ${data.message} <br>
                    <strong>Date:</strong> ${data.date}
                `;
            })
            .catch(err => console.log(err));
        }
    </script>
    <div class="container">
        <div id="message">Send your message to Aliens!</div>
        <button onclick="changeMessage()">Send to Aliens</button>
    </div>
</body>
</html>