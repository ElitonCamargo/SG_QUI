<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $.post( "http://sgqui.local/back/", ( data )=> {
            console.log(data);
        });

    </script>
</body>
</html>