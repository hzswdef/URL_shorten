<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <base href="/" />
    <title>URL Shorter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
</head>
<body>

<div class="wrap">

<div class="back-button" onclick="window.location.href='/token';">
    <img src="assets/API.png"/>

    <span>
        API
    </span>
</div>

<div class="main unselectable">
    <div class="input-bl">
        <input id="url-input" placeholder="example.xyz">
    </div>
    
    <div class="button-bl">
        <div class="rotate">Shorten</div>
    </div>
</div>

</div>

<script src="js/jquery-3.6.0.js"></script>
<script src="js/loading.js"></script>
<script src="js/send_request.js"></script>

</body>
</html>