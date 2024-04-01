<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        
    ?>
</body>

<script src="jquery-3.7.1.min.js"></script>
<script src="recursos.js"></script>
<script>
    const testeBusca = async ()=>{    
        await req_GET("back/ffff/gggg").then((result) => {
            console.log(result);
        });        
    }

    testeBusca();

</script>
</html>