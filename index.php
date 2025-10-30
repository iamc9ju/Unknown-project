<?php
    if(isset($_POST["controller"])){
        $controller = $_POST["controller"];
    }else{
        $controller = $_GET["controller"];
    }

    if(isset($_POST["action"])){
        $action = $_POST["action"]; 
    }else{
        $action = $_GET["action"];
    }

    if($controller == "" || $action == ""){
        $controller = 'pages';
        $action = 'home';
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <?php echo "controller = $controller, action = $action<br>"?>
        
        <?php require("routes.php"); ?>
    </body>
</html>