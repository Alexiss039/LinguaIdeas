<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recurso</title>
</head>
<body>
    <div style="position:relative; width:100%;">
        <div style="width:100%; background: #000; height:45px; position:absolute;">            
        </div>
        <iframe src="{{ asset($ruta_base . $tema->recurso) }}" frameborder="0" width="100%" height="700px;"></iframe>        
        </div>
</body>
</html>