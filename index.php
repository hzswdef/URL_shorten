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

<div id="loading-screen">
    <svg class="spinner" viewBox="0 0 50 50">
        <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
    </svg>
</div>

<div id="msg_box"></div>

<div class="main-block">
    <div class="form">
        <input id="url-input" placeholder="example.xyz">
        
        <button id="send_request">shorten</button>
        
        <span class="url-counter unselectable">
            <? echo "yo"; ?>
        </span>
    </div>
</div>

</div>

<script src="js/jquery-3.6.0.js"></script>
<script src="js/loading.js"></script>
<script src="js/send_request.js"></script>

</body>
</html>