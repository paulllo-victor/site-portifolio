<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="portifolio para testar meus conhecimento na programação front-end e back-end">
    <meta name="author" content="Paulo Victor - 26/09/2020">
    <meta name="keywords" content="aprendizagem,dashboard,site,dinamico">

    <link rel="stylesheet" href="../asset/css/stylePainel.css">

    <title>Login dashboard</title>
</head>
<body>
    <div class="container-login">
        <form action="" method="post" class="login">
        <?php
            if(isset($_POST["send-form"])){
                $user = Admin::logar($_POST["email"],$_POST["password"]);

                if($user){
                    header("Location: ".PATH_PAINEL."dashboard.php");
                    die();
                }else{
                    echo "falhou";
                }
            }
        ?>
            <input type="email" name="email" id="" placeholder="e-mail">
            <input type="password" name="password" id="" placeholder="password">
            <input type="submit" name="send-form" value="Entrar">
        </form>
    </div>
</body>
</html>