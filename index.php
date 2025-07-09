<?php
require_once  'config.php';
require_once  'database.php';

    $uri = $_GET['uri'] ?? 'home';
    $uri = str_replace('.php', '', $uri);
    $title= ucfirst($uri);
    $uri = $uri . '.php';
    $pagePath= __DIR__ . '/pages/' . $uri;


?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BCA :: <?= $title;?></title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<body>



<?php
if(file_exists($pagePath) && is_file($pagePath)){
    require $pagePath;
}else{
    echo '404 Not Found';
}
?>
</body>
</html>