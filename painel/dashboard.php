<?php 
    require_once "../config.php";
    require_once "../vendor/autoload.php";

    if(isset($_SESSION["login"])){
        if(!Admin::verificarToken($_SESSION["email"],$_SESSION["token_session"])){
            header('Location: '.PATH_PAINEL);
        }else{

        }
    }else{
        header('Location: '.PATH_PAINEL);
    }

    if(isset($_GET['deslogar']) && $_GET['deslogar'] == true){
        if(Admin::deslogar($_SESSION["email"])){
            header("Location: ". PATH_PAINEL);
        }
    }

?>
 <!DOCTYPE html>
 <html lang="UTF-8">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

     <meta name="description" content="Dashboard meu portifolio">
     <meta name="autor" content="Paulo Victor">
     <meta name="keywords"content="dashboard,paulo,victor,portifolio"> 

     <link rel="stylesheet" href="../asset/css/painel/style.css">
     <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

     <title>Dashboard</title>
 </head>
 <body>
     <div class="menu-left left">
        <div class="container-menu-left">
            <div class="avatar-user">
                <?php
                    if(isset($_SESSION["img-avatar"])){
                        ?>
                        <!-- VERIFICAR SE A FOTO EXISTE -->
                        <div class="img-avatar" style=" background-image: url('../asset/images/avatar/profile-img.png')"></div>
                        <?php
                    }else{
                         ?>
                         <div class="img-avatar" style=" background-image: url('../asset/images/avatar/profile-img.png')"></div>
                         <?php
                    }
                ?>
            </div>
            <div class="itens-menu-left">
                <div class="item-menu">
                    <h4>Home</h4>
                    <p><a href="<?= PATH_PAINEL.'homeCreate.php' ?>">Criar</a></p>
                    <p><a href="<?= PATH_PAINEL.'listBanners.php' ?>">Listar</a></p>
                </div>
                <div class="item-menu">
                    <h4>Portifolio</h4>
                    <p><a href="#">Criar</a></p>
                    <p><a href="#">Listar</a></p>
                </div>
                <div class="item-menu">
                    <h4>Resumo</h4>
                    <p><a href="#">Criar</a></p>
                    <p><a href="#">Listar</a></p>
                </div>
                <div class="item-menu">
                    <h4>Sobre mim</h4>
                    <p><a href="#">Criar</a></p>
                    <p><a href="#">Listar</a></p>
                </div>
                <div class="item-menu">
                    <h4>Depoimentos de clientes</h4>
                    <p><a href="#">Criar</a></p>
                    <p><a href="#">Listar</a></p>
                </div>
                <div class="item-menu">
                    <h4>Serviços</h4>
                    <p><a href="#">Criar</a></p>
                    <p><a href="#">Listar</a></p>
                </div>
                <div class="item-menu">
                    <h4>Blog</h4>
                    <p><a href="#">Criar</a></p>
                    <p><a href="#">Listar</a></p>
                </div>
                <div class="item-menu">
                    <h4>Contatos</h4>
                    <p><a href="#">Criar</a></p>
                    <p><a href="#">Listar</a></p>
                    <p><a href="#">Redes sociais</a></p>
                </div>
                <div class="item-menu">
                    <h4>Configurações</h4>
                    <p><a href="#">Alterar dados pessoais</a></p>
                    <p><a href="#">Adicionar novo usuário</a></p>
                    <p><a href="#">Listar todos os usuários cadastrados</a></p>
                </div>
            </div>
        </div>
     </div>

     <div class="menu-top right text-right">    
        <div class="text-left left btn-menu-left">
            <i class="fas fa-bars"></i>
        </div>    
        <div class="text-right right">
            <a class="link" href="<?= PATH_PAINEL ?>"><i class="fas fa-home"></i> Voltar para Home</a>
            <a class="link" href="<?= PATH_PAINEL ?>?deslogar=true"><i class="fas fa-times"></i> Deslogar</a>
        </div>
     </div>

     <div class="main right">
         <?php
            $countUrl = count(explode('/',$_SERVER["REQUEST_URI"]));
            $page = explode('/',$_SERVER["REQUEST_URI"]);

            if($page[$countUrl-1] == 'dashboard.php' || $page[$countUrl-1] == 'dashboard' || $page[$countUrl-1] == ''){
                include('pages/home.php');
            }else{
                $namePage = strpos($page[$countUrl-1],'.php') ? 'pages/'.$page[$countUrl-1] : 'pages/'.$page[$countUrl-1].'.php';
                
                if(is_file(strstr($namePage,'?',true))){
                    include(strstr($namePage,'?',true));
                }else if(is_file($namePage)){
                    include($namePage);
                }else{
                    include('pages/home.php');
                }
            }
         ?>
     </div>
     
     <div class="clear"></div>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="../asset/js/functions.js"></script>
 </body>
 </html>