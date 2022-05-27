<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <base href="/" />
    <title>hzswdef | Token</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/token_.css">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
</head>
<body>

<div class="wrap">

<div class="back-button" onclick="window.location.href='/';">
    <img class="unselectable" src="assets/logout.png"/>

    <span class="unselectable">
        Back
    </span>
</div>

<div class="notify">
    Copied to clipboard.
</div>

<div class="content-wrap">
    <div class="token-div">
        <div class="token-btn" id="gen_token_btn">
            <span id="res">GENERATE TOKEN</span>
            
            <div class="copy-btn" onclick="copy('#res');">
                <img src="assets/copy.png" id="copy-btn">
            </div>
        </div>
    </div>
    
    <div class="docs-div" onclick="window.location.href = '/docs';">
        <div class="rotate unselectable">DOCS</div>
    </div>
</div>

</div>

<script src="js/jquery-3.6.0.js"></script>
<script src="js/gen_token.js"></script>

</body>
</html>