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

<div id="msg_box"></div>

<div class="back-button" onclick="window.location.href='/token';">
    <img src="assets/api.png"/>

    <span>
        API
    </span>
</div>

<div class="main">
    <div class="input-bl">
        <input id="url-input" placeholder="example.xyz">
    </div>
    
    <div class="button-bl" id="send_request">
        <div class="rotate">Shorten</div>
    </div>
</div>

</div>

<script src="js/jquery-3.6.0.js"></script>
<script src="js/loading.js"></script>
<script src="js/send_request.js"></script>
<script>
    var scrolled = false;
    function updateScroll(){
        if(!scrolled){
            var element = document.getElementById("msg_box");
            element.scrollTop = element.scrollHeight;
        }
    }
    
    $("#msg_box").on('scroll', function(){
        scrolled=true;
    });
</script>

</body>
</html>
