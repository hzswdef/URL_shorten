<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <base href="/" />
    <title>API Docs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/docs_.css">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
</head>
<body>

<div class="wrap">

<div class="api-item">
    <div class="title">
        GET /api
    </div>
    
    <div class="quick-desc">
        Create short url
    </div>
    
    <div class="hr"></div>
    
    <div class="examples-title">
        Examples
    </div>
    
    <div class="examples">
        GET /api<br>
        <a>200</a>
        <p>
            <code class="prettyprint">
                {
                  "url": "https://url.hzswdef.xyz/_test"
                }
            </code>
        </p>
    </div>
    
    <div class="params-title">
        Params
    </div>
        
    <table class="params">
        <thead>
            <tr>
                <th>Param name</th>
                <th>Desc</th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <td>token</td>
                <td>
                    Access the <span>API</span>.
                    Tokens could be found <a href="/token">here</a>.
                </td>
            </tr>
            
            <tr>
                <td>url</td>
                <td>
                    Link to needed website. <br><br>
                    <span>Validations:</span>
                    <ul>
                        <li>Availability check.</li>
                        <li>Max 256 characters.</li>
                    </ul>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</div>

<script src="https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js"></script>

</body>
</html>